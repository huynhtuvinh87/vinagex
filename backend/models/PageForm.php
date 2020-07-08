<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\components\Constant;
use common\models\Page;
use common\models\TranslationProduct;

class PageForm extends Model {

    /**
     * @inheritdoc
     */
    public $id;
    public $title;
    public $slug;
    public $content;
    public $url;
    public $image;
    public $widget;
    public $status;
    public $created_at;
    public $updated_at;
    public $fileImg;
    public $_model;

    public function rules() {
        return [
            [['title', 'content', 'status', 'widget'], 'required'],
            [['status', 'widget'], 'integer'],
            [['url'], 'default'],
            [['fileImg'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,jpeg'],
        ];
    }

    public function init() {
        parent::init();
        if ($this->id) {
            $model = Page::findOne($this->id);
            $this->_model = $model;
            $this->attributes = $model->attributes;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Tiêu đề',
            'content' => 'Nội dung',
            'image' => 'Hình ảnh',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày tạo',
            'url' => 'Đương dẫn'
        ];
    }

    public function widget() {
        return Page::widget();
    }

    public function save() {

        if ($this->validate()) {
            $transtion = new TranslationProduct();
            $collection = Yii::$app->mongodb->getCollection('page');

            $file = UploadedFile::getInstance($this, 'fileImg');

            $this->slug = Constant::slug($this->title);
            $this->updated_at = time();
            $this->created_at = time();

            $data = [
                'title' => $this->title,
                'content' => $this->content,
                'url' => $this->url,
                'slug' => $this->slug,
                'widget' => (int) $this->widget,
                'status' => (int) $this->status,
                'updated_at' => $this->updated_at,
            ];

            if ($file) {
                $name = time() . '.' . $file->extension;

                if (!file_exists(\Yii::getAlias("@cdn/web/images/pages"))) {
                    mkdir(\Yii::getAlias("@cdn/web/images/pages"), 0777, true);
                }
                $file->saveAs(\Yii::getAlias("@cdn/web/images/pages/" . $name));

                $this->image = 'images/pages/' . $name;
                $data['image'] = $this->image;
            }


            if ($this->id) {
                if ($file) {
                    $nameImage = $collection->findOne(['_id' => $this->id])['image'];
                    unlink(\Yii::getAlias("@cdn/web/" . $nameImage));
                }
                if ($this->_model['title'] != $data['title']) {
                    $transtion->add('data', [
                        'message' => 'page_title_' . $this->id, 'translation' => $data['title']
                    ]);
                }

                if ($this->_model['content'] != $data['content']) {
                    $transtion->add('data', [
                        'message' => 'page_content_' . $this->id, 'translation' => $data['content']
                    ]);
                }
                
                return $collection->update(['_id' => $this->id], $data);
            } else {
                $id = $collection->insert(array_merge($data, ['created_at' => $this->created_at]));
                $transtion->add('data', [
                    'message' => 'page_title_' . $id, 'translation' => $data['title']
                ]);
                $transtion->add('data', [
                    'message' => 'page_content_' . $id, 'translation' => $data['content']
                ]);
                return $id;
            }
        }
    }

}
