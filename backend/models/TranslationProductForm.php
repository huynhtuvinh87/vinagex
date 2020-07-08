<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\mongodb\Query;

class TranslationProductForm extends Model {

    public $id;
    public $language;
    public $title;
    public $content;
    public $_messages;

    public function init() {
        parent::init();
        if (!empty($this->id)) {
            $translation = (new Query)->from('translation_product')->where(['language' => $this->language])->one();
            $message = $translation['messages'][$this->id];
            $this->_messages = $message;
            $this->title = $message['message'];
            $this->content = $message['translation'];
            $this->language = $translation['language'];
        }
    }

    public function rules() {
        return [
            [['content'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Tiêu đề',
            'content' => 'Nội dung'
        ];
    }

    public function messages() {
        $translation = (new Query)->from('translation_product')->where(['language' => 'en'])->one();
        return !empty($translation['messages'][$this->id]['message'])?$translation['messages'][$this->id]['message']:'';
    }

    public function save() {
        
        if ($this->validate()) {
            $data = [
                'message' => trim($this->title),
                'translation' => $this->content,
            ];

            if (!empty($this->id)) {
                Yii::$app->mongodb->getCollection('translation_product')->update(['language' => $this->language], ['$set' => [
                        'messages.' . $this->id => $data
                ]]);
            }
            return true;
        }
    }

}
