<?php

namespace rfq\storage;

use Yii;
use yii\mongodb\Query;
use common\components\Constant;

class RfqApply {

    var $data;

    function __construct($data) {
        $this->data = $data;
    }

    public function getId() {
        return (string) $this->data['_id'];
    }

    public function getTitle() {
        return (string) $this->data['rfq']['title'];
    }

    public function getContent() {
        return (string) $this->data['rfq']['content'];
    }

    public function getPrice() {
        return Constant::price($this->data['rfq']['price']);
    }

    public function getQuantity() {
        return $this->data['rfq']['quantity'] . ' ' . Yii::t('rfq', $this->data['rfq']['unit']);
    }

    public function getDatestart() {
        return \Yii::$app->formatter->asDatetime($this->data['rfq']['date_start'], "php:d/m/Y");
    }

    public function getDateend() {
        return \Yii::$app->formatter->asDatetime($this->data['rfq']['date_end'], "php:d/m/Y");
    }

    public function getPriceOffer() {
        return Constant::price($this->data['price']);
    }

    public function checkOwner() {
        if (\Yii::$app->user->id == $this->data['owner']['id']) {
            return TRUE;
        }
        return FALSE;
    }

    public function checkActor() {
        if (\Yii::$app->user->id == $this->data['actor']['id']) {
            return TRUE;
        }
        return FALSE;
    }

}
