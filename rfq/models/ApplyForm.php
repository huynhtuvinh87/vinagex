<?php

namespace rfq\models;

use Yii;
use yii\base\Model;
use yii\mongodb\Query;
use common\components\Constant;

class ApplyForm extends Model {

    public $id;
    public $price;
    public $description;

    public function init() {
        parent::init();
    }

    public function rules() {
        return [
            [['price'], 'required', 'message' => '{attribute} ' . Yii::t('rfq', 'không được để trống')],
            [['description'], 'string'],
            ['description', 'string', 'max' => 500, 'tooLong' => '{attribute} ' . Yii::t('rfq', 'chỉ được nhập {0} ký tự', '500')],
            ['price', 'string', 'min' => 5, 'max' => 15, 'tooShort' => '{attribute} ' . Yii::t('rfq', 'không được nhỏ hơn {0}', '1,000đ'), 'tooLong' => '{attribute} ' . Yii::t('rfq', 'không được lớn hơn {0}', '999,999,999,999')],
        ];
    }

    public function attributeLabels() {
        return [
            'price' => Yii::t('rfq', 'Giá'),
            'description' => Yii::t('rfq', 'Mô tả')
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return null;
        }
        $rfq = (new Query)->from('rfq')->where(['_id' => $this->id])->one();
        $price = str_replace(',', '', $this->price);
        $data = [
            'actor' => [
                'id' => \Yii::$app->user->id,
                'fullname' => \Yii::$app->user->identity->fullname,
                'phone' => \Yii::$app->user->identity->phone,
                'garden_name' => !empty(\Yii::$app->user->identity->garden_name) ? \Yii::$app->user->identity->garden_name : '',
                'username' => \Yii::$app->user->identity->username
            ],
            "owner" => $rfq['owner'],
            'rfq' => [
                'id' => (string) $rfq['_id'],
                'title' => $rfq['title'],
                'date_start' => $rfq['date_start'],
                'date_end' => $rfq['date_end'],
                'price' => (int) $rfq['price'],
                'quantity' => $rfq['quantity'],
                'unit' => $rfq['unit']
            ],
            'price' => (int) $price,
            'status' => Constant::STATUS_PENDING,
            'created_at' => time(),
            'updated_at' => time(),
        ];

        if (!empty($this->description)) {
            $data['description'] = $this->description;
        }

        if (!empty($rfq['images'])) {
            $data['rfq']['images'] = $rfq['images'];
        }

        Yii::$app->mongodb->getCollection('rfq_offer')->insert($data);
        Yii::$app->mongodb->getCollection('notification')->insert([
            'type' => 'admin',
            'content' => '<b>' . \Yii::$app->user->identity->fullname . '</b> đã báo giá <b>' . $rfq['title'] . '</b>',
            'url' => '/rfq/view/' . (string) $rfq['_id'],
            'status' => 0,
            'created_at' => time()
        ]);
        return true;
    }

}
