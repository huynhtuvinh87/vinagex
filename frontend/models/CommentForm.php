<?php

namespace frontend\models;

use yii\base\Model;
use Yii;
use common\models\Product;
use common\models\Comment;

class CommentForm extends Model {

    public $name;
    public $vocative;
    public $email;
    public $content;
    public $images;
    public $parent;
    public $sex;
    public $product_id;
    public $ip;
    public $url;

    public function init() {
        parent::init();
        $this->sex = 'Anh';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['name', 'required', 'message' => ''],
            ['content', 'trim'],
            ['content', 'required', 'message' => ''],
            ['email', 'trim'],
            ['email', 'required', 'message' => ''],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['product_id', 'parent'], 'string'],
            [['parent'], 'default', 'value' => 0],
            [['sex', 'url'], 'string'],
//            [['images'], 'file', 'extensions' => 'jpg, gif, png'], //max size is 2mb
//            ['images', 'image', 'minWidth' => 250, 'maxWidth' => 450, 'minHeight' => 250, 'maxHeight' => 450],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => Yii::t('frontend', 'Họ và tên'),
            'email' => Yii::t('frontend', 'Email'),
            'content' => Yii::t('frontend', 'Nội dung'),
            'images' => Yii::t('frontend', 'Hình ảnh')
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save() {

        $product = Product::findOne($this->product_id);

        $data = [
            'ip' => $this->ip,
            'product' => [
                'id' => $product->id,
                'title' => $product->title,
                'slug' => $product->slug,
                'image' => $product->images[0],
                'owner' => $product->owner,
                'province' => $product->province,
                'unit_of_calculation' => $product->unit,
            ],
            'parent' => $this->parent,
            'sex' => $this->sex,
            'id_owner' => \Yii::$app->user->id,
            'name' => $this->name,
            'email' => $this->email,
            'content' => $this->content,
            'count_answer' => 0,
            'created_at' => time(),
            'updated_at' => time()
        ];

        $data['status'] = Yii::$app->user->id == $product->owner['id'] ? Comment::STATUS_ACTIVE : Comment::STATUS_NOACTIVE;

        $comment = Yii::$app->mongodb->getCollection('comment')->insert($data);

        if ($data['status'] == Comment::STATUS_NOACTIVE) {
            Yii::$app->mongodb->getCollection('notification')->insert([
                'type' => 'seller',
                'owner' => $product->owner['id'],
                'content' => '<b>' . $this->name . '</b> đã bình luận sản phẩm <b>' . $product->title . '</b>',
                'url' => Yii::$app->setting->get('siteurl_seller') . '/comment/index?CommentSearch[id]=' . (string) $comment,
                'status' => 0,
                'created_at' => time()
            ]);

            Yii::$app->mongodb->getCollection('notification')->insert([
                'type' => 'admin',
                'content' => '<b>' . $this->name . '</b> đã bình luận sản phẩm <b>' . $product->title . '</b>',
                'url' => '/comment/index?CommentSearch[id]=' . (string) $comment,
                'status' => 0,
                'created_at' => time()
            ]);
        }

        if ($comment) {
            return $comment;
        }
        return FALSE;
    }

}
