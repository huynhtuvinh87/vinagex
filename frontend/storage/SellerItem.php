<?php

namespace frontend\storage;

use Yii;
use common\models\PaymentHistory;
use common\models\Review;
use yii\mongodb\Query;
use common\components\Constant;

class SellerItem {

    /**
     * @var object $product
     */
    public $_user;

    function __construct($data) {
        $this->_user = $data;
    }

    public function getId() {
        return (string) $this->_user['_id'];
    }

    public function getName() {
        return $this->_user['fullname'];
    }

    public function getGardenName() {
        return Yii::t('data', trim($this->_user['garden_name']));
    }

    public function getUsername() {
        return $this->_user['username'];
    }

    public function getAddress() {
        return $this->_user['address'] . ',' . $this->_user['ward']['name'] . ',' . $this->_user['district']['name'] . ',' . $this->_user['province']['name'];
    }

    public function getTrademark() {
        return !empty($this->_user['trademark']) ? Yii::t('data', trim($this->_user['trademark'])) : FALSE;
    }

    public function getCertificate() {
        if (!empty($this->_user['certificate'])) {
            $data = [];
            foreach ($this->_user['certificate'] as $key => $value) {
                $data[] = '<a href="/filter?certification[]=' . $value['id'] . '">' . Yii::t('data', trim($value['name'])) . '</a>';
            }
            return implode(', ', $data);
        }
        return FALSE;
    }

    public function getAcreage() {
        return $this->_user['acreage'] . ' ' . $this->_user['acreage_unit'];
    }

    /**
     * Returns the 0utput Provided of the item
     * @return string
     */
    public function get0utputProvided() {
        return $this->_user['output_provided'] . ' ' . Yii::t('common', $this->_user['output_provided_unit']);
    }

    public function getCreated() {
        return date('d/m/Y', $this->_user['created_at']);
    }

    public function getMoney() {
        if ($this->_user['active']['insurance_money'] == 1) {
            return Constant::price($this->_user['insurance_money']) . ' vnđ';
        }
        return FALSE;
    }

    public function getUrl() {
        return Yii::$app->urlManager->createAbsoluteUrl([!empty($this->getUsername()) ? '/nha-cung-cap/' . $this->getUsername() . '-' . $this->getId() : '/nha-vuon/' . $this->getId()]);
    }

    /**
     * Returns the price of the item
     * @return integer|float
     */
    public function getCountPaymentHistory() {
        return PaymentHistory::find()->where(['owner' => $this->getId()])->count();
    }

    public function getCountReview() {
        return Review::find()->where(['owner.id' => $this->getId(), 'status' => Constant::STATUS_ACTIVE])->count();
    }

    public function countstar($star) {
        return Review::find()->where(['owner.id' => $this->getId(), 'star' => $star, 'status' => Constant::STATUS_ACTIVE])->count();
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

    public function getPercentageDeal() {

        $order_final = (new Query)->from('order')->where(['owner.id' => $this->getId()])->orderBy(['_id' => SORT_DESC])->one();

        if ($order_final) {
            $order_seven_days_ago = $order_final['created_at'] - 604800;

            $total_order_success = (new Query)->from('order')->where(['owner.id' => $this->getId()])->andWhere(['>=', 'created_at', $order_seven_days_ago])->andWhere(['NOT IN', 'status', [Constant::STATUS_ORDER_PENDING, Constant::STATUS_ORDER_BLOCK]])->count();

            $total = (new Query)->from('order')->where(['owner.id' => $this->getId()])->andWhere(['>=', 'created_at', $order_seven_days_ago])->count();

            if ($total > 0) {
                $percentage_complete = ($total_order_success / $total) * 100;
            } else {
                $percentage_complete = 0;
            }
            return number_format((float) $percentage_complete, 0, '.', '');
        } else {
            return 0;
        }
    }

    public function getCountDeal() {
        $finish = (new Query)->from('order')->where(['owner.id' => $this->getId(), 'status' => Constant::STATUS_ORDER_FINISH])->count();
        return $finish;
    }

    public function getPayment() {
        if (!empty($this->_user['payment'])) {
            $data = [];
            foreach ($this->_user['payment'] as $value) {
                $data[] = Yii::t('common', $value['title']) . (!empty($value['percent']) ? ' ' . $value['percent'] . "%" : "");
            }
            return implode(', ', $data);
        }
        return FALSE;
    }

    public function getLike() {
        $query = (new Query)->from('wishlist')->where(['user_id' => \Yii::$app->user->id, 'seller_id' => $this->getId()])->one();
        if ($query) {
            return TRUE;
        }
        return FALSE;
    }

}
