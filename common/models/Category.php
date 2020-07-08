<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\web\UploadedFile;

class Category extends ActiveRecord {

    public $type = [];
    public $today;

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'category';
    }

    public function attributes() {
        return [
            '_id',
            'parent',
            'title',
            'slug',
            'description',
            'unit',
            'oscillation_unit',
            'order',
            'icon'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title'], 'required'],
            [['type', 'unit'], 'default'],
            [['description','icon'], 'string']
        ];
    }

    public function init() {
        $time = new \DateTime('now');
        $this->today = $time->format('Y-m-d');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Tiêu đề',
            'description' => 'Mô tả',
            'parent_id' => 'Danh mục',
            'image' => 'Hình ảnh'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
            'slugBehavior' => [
                'class' => \common\components\SluggableBehavior::className(),
                'attribute' => 'title'
            ],
        ]);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {

            return true;
        }
        return false;
    }

    public function category() {
        $category = self::find()->where(['parent_id' => ""])->all();
        $data = [];
        if (!empty($category)) {
            foreach ($category as $key => $value) {
                $data[$value['id']] = $value['title'];
            }
        }
        return $data;
    }

    public function getCount() {
        return Product::find()->where(['category.id' => $this->id])->count();
    }

    public function product($type = NULL) {
        if (!empty($type)) {
            return Product::active()->andWhere(['time_to_sell' => $type, 'category.id' => $this->id])->orderBy(['created_at' => SORT_DESC])->limit(10)->all();
        }
        return Product::active()->andWhere(['category.id' => $this->id])->limit(4)->all();
    }

    public function getProductAvailable() {
        return Product::active()->andWhere(['category.id' => $this->id])->limit(4)->all();
    }

}
