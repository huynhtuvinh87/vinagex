<?php

namespace rfq\storage;

use Yii;
use yii\mongodb\Query;
use common\components\Constant;

class RfqItem {

    var $data;

    function __construct($data) {
        $this->data = $data;
    }

    public function getId() {
        return (string) $this->data['_id'];
    }

    public function getCategory() {
        return Yii::t('data', 'sub_category_' . $this->data['product_type']['id']);
    }

    public function getCategoryId() {
        return (string) $this->data['product_type']['id'];
    }

    public function getTitle() {
        return $this->data['title'];
    }

    public function getSlug() {
        return $this->data['title'];
    }

    public function getContent() {
        return $this->data['content'];
    }

    public function getPrice() {
        return Constant::price($this->data['price']);
    }

    public function getQuantity() {
        return $this->data['quantity'] . ' ' . Yii::t('rfq', $this->data['unit']);
    }

    public function getUnit() {
        return Yii::t('common', $this->data['unit']);
    }

    public function getDatestart() {
        return \Yii::$app->formatter->asDatetime($this->data['date_start'], "php:d/m/Y");
    }

    public function getDateend() {
        return \Yii::$app->formatter->asDatetime($this->data['date_end'], "php:d/m/Y");
    }

    public function getImg() {
        return !empty($this->data['images'][0]) ? Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . $this->data['images'][0] . '&size=120x120' : '/images/no_image_available.png';
    }

    public function getOwnerId() {
        return $this->data['owner']['id'];
    }

    public function getOwnerName() {
        return $this->data['owner']['fullname'];
    }

    public function getUrl() {
        return \Yii::$app->request->hostInfo . '/' . $this->data['slug'] . '-' . $this->getId();
    }

    public function countOffer() {
        return (new Query)->from('rfq_offer')->where(['rfq.id' => $this->getId()])->count();
    }

    public function checkOffer() {
        $query = (new Query)->from('rfq_offer')->where(['rfq.id' => $this->getId(), 'actor.id' => \Yii::$app->user->id])->orWhere(['rfq.id' => $this->getId(), 'owner.id' => \Yii::$app->user->id])->one();
        if ($query) {
            return TRUE;
        }
        return FALSE;
    }

    public function checkOfferStatus() {
        $query = (new Query)->from('rfq_offer')->where(['rfq.id' => $this->getId(), 'actor.id' => \Yii::$app->user->id])->one();
        if ($query) {
            return $query['status'];
        }
        return FALSE;
    }

    public function checkOwner() {
        $query = (new Query)->from('rfq')->where(['_id' => $this->getId(), 'owner.id' => \Yii::$app->user->id])->one();
        if ($query) {
            return TRUE;
        }
        return FALSE;
    }

}
