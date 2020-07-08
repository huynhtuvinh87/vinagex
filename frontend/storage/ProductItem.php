<?php

namespace frontend\storage;

use Yii;
use yii\mongodb\Query;
use common\components\Constant;
use common\models\Product;

class ProductItem {

    var $data;

    function __construct($data) {
        $this->data = $data;
    }

    public function getId() {
        return (string) $this->data['_id'];
    }

    public function getTitle() {
        return (string) $this->data['title'];
    }

    public function getUrl() {
        return \Yii::$app->setting->get('siteurl') . '/' . $this->data['slug'] . '-' . $this->getId();
    }

    public function getPrice() {
        if (!empty($this->data['classify'])) {
            $array = [];
            foreach ($this->data['classify'] as $val) {
                $array[] = $val['price_min'];
                $array[] = $val['price_max'];
            }
            if (min($array) == max($array)) {
                $price = Constant::price(max($array));
            } else {
                $price = Constant::price(min($array)) . ' - ' . Constant::price(max($array));
            }
        } else {
            if ($this->data['price']['min'] == $this->data['price']['max']) {
                $price = Constant::price($this->data['price']['min']);
            } else {
                $price = Constant::price($this->data['price']['min']) . ' - ' . Constant::price($this->data['price']['max']);
            }
        }
        return $price;
    }

    public function getDateEnd() {
        return $this->data['time_end'];
    }

    public function getDateStart() {
        return $this->data['time_begin'];
    }

    public function getTotalReview() {
        $star1 = $this->countstar(1);
        $star2 = $this->countstar(2);
        $star3 = $this->countstar(3);
        $star4 = $this->countstar(4);
        $star5 = $this->countstar(5);
        if (($star1 + $star2 + $star3 + $star4 + $star5) > 0) {
            $total = (($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1)) / ($star1 + $star2 + $star3 + $star4 + $star5);
        } else {
            $total = 0;
        }
        return round($total, 2);
    }

    public function countstar($star) {
        return (new Query)->from('review')->where(['product.id' => $this->getId(), 'star' => $star, 'status' => Constant::STATUS_ACTIVE])->count();
    }

    public function getCountdown() {
        if ($this->data['time_to_sell'] == Product::TIMETOSELL_2) {
            return TRUE;
        }
        return FALSE;
    }

    public function getUsername() {
        return $this->data['owner']['username'];
    }

    public function getGardenname() {
        return Yii::t('user', $this->data['owner']['garden_name']);
    }

    public function getOwnerUrl() {
        return Yii::$app->urlManager->createAbsoluteUrl(['/nha-cung-cap/' . $this->data['owner']['username'] . '-' . $this->data['owner']['id']]);
    }

    public function getMinimum() {
        if ($this->data['unit'] == 'kg' && $this->data['quantity_min'] >= 1000) {
            return $this->data['quantity_min'] / 1000;
        }
        return $this->data['quantity_min'];
    }

    public function getUnit() {
        if ($this->data['unit'] == 'kg' && $this->data['quantity_min'] >= 1000) {
            return Yii::t('common', 'tấn');
        }
        return Yii::t('common', $this->data['unit']);
    }

    public function getImage() {
        return Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . $this->data['images'][0] . '&size=370x300';
    }

    public function getCountReview() {
        return (new Query)->from('review')->where(['product.id' => $this->getId(), 'status' => Constant::STATUS_ACTIVE])->count();
    }

}
