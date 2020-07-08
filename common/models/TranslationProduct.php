<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Query;

class TranslationProduct extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'translation_data';
    }

    /**
     * @inheritdoc
     */
    public function attributes() {
        return [
            '_id',
            'category',
            'language',
            'messages',
        ];
    }

    public function add($category, $messages) {
        $translation = (new Query)->from('translation_data')->where(['category' => $category, 'messages.message' => $messages['message']])->one();
        if (!empty($translation)) {
            $key = array_search($messages['message'], array_column($translation['messages'], 'message'));
            Yii::$app->mongodb->getCollection('translation_data')->update(['category' => $category, 'messages.message' => $messages['message']], ['$set' => [
                    'messages.' . $key => $messages
            ]]);
        } else {
            Yii::$app->mongodb->getCollection('translation_data')->update(['category' => $category], ['$push' => ['messages' => $messages]]);
        }
    }

    public function product($language, $category, $messages) {
        $translation = (new Query)->from('translation_product')->where(['language' => $language, 'category' => $category, 'messages.message' => $messages['message']])->one();
        if (!empty($translation)) {
            $key = array_search($messages['message'], array_column($translation['messages'], 'message'));
            Yii::$app->mongodb->getCollection('translation_product')->update(['language' => $language, 'category' => $category, 'messages.message' => $messages['message']], ['$set' => [
                    'messages.' . $key => $messages
            ]]);
        } else {
            Yii::$app->mongodb->getCollection('translation_product')->update(['language' => $language, 'category' => $category], ['$push' => ['messages' => $messages]]);
        }
    }

    public function user($language, $category, $messages) {
        $translation = (new Query)->from('translation_user')->where(['language' => $language, 'category' => $category, 'messages.message' => $messages['message']])->one();
        if (!empty($translation)) {
            $key = array_search($messages['message'], array_column($translation['messages'], 'message'));
            Yii::$app->mongodb->getCollection('translation_user')->update(['language' => $language, 'category' => $category, 'messages.message' => $messages['message']], ['$set' => [
                    'messages.' . $key => $messages
            ]]);
        } else {
            Yii::$app->mongodb->getCollection('translation_user')->update(['language' => $language, 'category' => $category], ['$push' => ['messages' => $messages]]);
        }
    }

}
