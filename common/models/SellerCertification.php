<?php

namespace common\models;

use yii\db\ActiveRecord;
use common\models\Certification;

class SellerCertification extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%seller_certification}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
        ];
    }

    public function getCertification() {
        return $this->hasOne(Certification::className(), ['id' => 'certification_id']);
    }

}
