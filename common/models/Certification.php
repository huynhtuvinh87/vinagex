<?php

namespace common\models;

use yii\mongodb\ActiveRecord;

class Certification extends ActiveRecord {

    public static function collectionName() {
        return 'certification';
    }

    public function attributes() {
        return [
            '_id',
            'name',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => 'Tiêu đề',
        ];
    }

    public function getId(){
        return (string) $this->_id;
    }
}
