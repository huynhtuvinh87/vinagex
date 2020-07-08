<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\mongodb\Query;

class ProductForm extends Model {

    public $id;
    public $note_cancel;
    public $title;

    public function init() {
        parent::init();
        $product = (new Query)->from('product')->where(['_id' => $this->id])->one();
        $this->title = $product['title'];
    }

    public function rules() {
        return [
            [['note_cancel'], 'required', 'message' => '{attribute} không được bỏ trống'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'note_cancel' => 'Nội dung',
        ];
    }

    public function getError() {
        return [
            1 => 'Tiêu đề không hợp lý',
            2 => 'Hình ảnh không thực thế',
            3 => 'Mô tả không hợp lý',
            4 => 'Gía không hợp lý',
            5 => 'Số lượng không hợp lý',
            6 => 'Thời gian bán không hợp lý'
        ];
    }

}
