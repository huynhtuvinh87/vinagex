<?php

namespace seller\models;

use yii\base\Model;
use common\components\Constant;
use yii\mongodb\Query;

/**
 * Login form
 */
class ProductImageForm extends Model {

    public $product_id;
    public $content;
    public function init() {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['content'], 'required', 'message' => '{attribute} không được trống'],
        ];
    }


    public function attributeLabels() {
        return [
            'content' => 'Chi tiết và hình ảnh',
        ];
    }

}
