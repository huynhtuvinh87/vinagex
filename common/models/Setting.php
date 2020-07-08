<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;

class Setting extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'setting';
    }

    public function attributes() {
        return [
            '_id',
            'key',
            'name',
            'email',
            'description',
            'siteurl',
            'siteurl_backend',
            'siteurl_seller',
            'siteurl_id',
            'siteurl_message',
            'siteurl_cdn',
            'siteurl_transport',
            "address",
            "phone",
            "copyright",
            "smtp_host",
            "smtp_port",
            "smtp_encryption",
            "smtp_username",
            "smtp_password",
            "firebase_apikey",
            "firebase_database_url"
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'siteurl', 'phone', 'address', 'description', 'copyright', 'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'smtp_encryption', 'email', 'siteurl',
            'siteurl_backend',
            'siteurl_seller',
            'siteurl_id',
            'siteurl_message',
            'siteurl_cdn',
            'siteurl_transport'
                ], 'string'],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Tên nhà vườn',
            'siteurl' => 'URL nhà vườn',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'description' => 'Mô tả',
            'copyright' => 'Bản quyền',
            'siteurl_id' => 'URL ID',
            'siteurl_backend' => 'URL Admin',
            'siteurl_seller' => 'URL Bán hàng',
            'siteurl_transport' => 'URL Vận chuyển',
            'path_upload' => 'Đường dẫn Upload',
            'siteurl_cdn' => 'URL CDN',
            'siteurl_message' => 'URL tin nhắn',
        ];
    }

}
