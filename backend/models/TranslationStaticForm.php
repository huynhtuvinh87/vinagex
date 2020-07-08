<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\components\Constant;
use yii\mongodb\Query;

class TranslationStaticForm extends Model {

    public $id;
    public $language;
    public $title;
    public $content;
    public $_messages;

    public function init() {
        parent::init();
        if (!empty($this->id)) {
            $translation = (new Query)->from('translation_static')->where(['language' => $this->language])->one();
            $message = $translation['messages'][$this->id];
            $this->_messages = $message;
            $this->title = $message['message'];
            $this->content = $message['translation'];
            $this->language = $translation['language'];
        }
    }

    public function rules() {
        return [
            [['title', 'content', 'language'], 'string'],
            ['title', function ($attribute, $params) {
                    if (!empty($this->title)) {
                        $count = (new Query)->from('translation_static')->where(['language' => 'vi', 'messages.message' => $this->title])->count();
                        if (empty($this->id) && $count == 1) {
                            $this->addError('title', "Đã tồn tại");
                        }
                    }
                }],
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

    public function en() {
        $translation = (new Query)->from('translation_static')->where(['language' => 'en'])->one();
        $data = [];
        foreach ($translation['messages'] as $value) {
            $data[$value['message']] = $value['message'];
        }
        return $data;
    }

    public function save() {
        if ($this->validate()) {
            $data = [
                'message' => trim($this->title),
                'translation' => $this->content,
            ];

            if (!empty($this->id)) {
                Yii::$app->mongodb->getCollection('translation_static')->update(['language' => $this->language], ['$set' => [
                        'messages.' . $this->id => $data
                ]]);
            } else {
                if ($this->language == 'vi') {
                    Yii::$app->mongodb->getCollection('translation_static')->update(['category' => 'static'], ['$push' => ['messages' => $data]]);
                } else {
                    Yii::$app->mongodb->getCollection('translation_static')->update(['language' => $this->language], ['$push' => ['messages' => $data]]);
                }
            }
            return true;
        }
    }

}
