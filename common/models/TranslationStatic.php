<?php

namespace common\models;

use yii\mongodb\ActiveRecord;


class TranslationStatic extends ActiveRecord {


    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'translation_static';
    }

    /**
     * @inheritdoc
     */
    public function attributes(){
        return [
            '_id',
            'category',
            'language',
            'messages',
        ];
    }
}
