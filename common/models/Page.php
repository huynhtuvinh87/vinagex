<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;

class Page extends ActiveRecord {

    const STATUS_PUBLIC = 0; // hien thi
    const STATUS_PRIVATE = 1; // ko hien thi
    const WIDGET_INFO = 1; // GIOI THIEU
    const WIDGET_COOPERATE = 2; // HOP TAC VA TUYEN DUNG
    const WIDGET_SUPPORT = 3; // HO TRO
    const WIDGET_ADDRESS = 4; //ADDRESS CONG TY
    const WIDGET_TUTORIAL = 6; //huong dan

    /**
     * @inheritdoc
     */

    public static function collectionName() {
        return 'page';
    }

    public function init() {
        parent::init();
        // if ($this->image) {
        //     $this->link_url = explode(',', $this->image)[1];
        // }
    }

    /**
     * @inheritdoc
     */
    public function attributes() {
        return [
            '_id',
            'title',
            'url',
            'slug',
            'content',
            'image',
            'widget',
            'status',
            'created_at',
            'updated_at',
        ];
    }

    public function widget() {
        return [
            self::WIDGET_INFO => Yii::t('common', 'Về Viangex'),
            self::WIDGET_COOPERATE => Yii::t('common', 'Hợp tác và tuyển dụng'),
            self::WIDGET_SUPPORT => Yii::t('common', 'Hướng dẫn cho người mua - người bán'),
            self::WIDGET_ADDRESS => Yii::t('common', 'Công ty cổ phần Vinagex'),
            self::WIDGET_TUTORIAL => Yii::t('common', 'Hướng dẫn'),
        ];
    }

}
