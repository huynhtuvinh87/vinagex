<?php

namespace forum\models;

use Yii;
use yii\base\Model;
use common\models\Category;
use common\models\Setting;
use yii\mongodb\Query;
use common\components\Constant;
use common\models\Question;
/**
 * 
 */
class QuestionForm extends Model {

    public $id;
    public $title;
    public $slug;
    public $content;
    public $category;
    public $product_type;
    public $view;
    public $category_id;
    public $_userInfo;
    public $_setting;
    public $user_id;

    public function init() {
        $this->_setting = Setting::findOne(['key' => 'config']);
        if($this->id){
            $model = Question::findOne($this->id);
            $this->user_id = $model['user']['id'];
            $this->attributes = $model->attributes;

            $this->category_id = $model->category;

            $this->product_type = $model->product_type['id'];

        }

    }

    public function rules() {
        return [
            [['title', 'content'], 'required', 'message' => '{attribute} Không được để trống'],
            [['category_id', 'product_type'], 'required', 'message' => '{attribute} Chưa được chọn'],
            // [['title','content'],
            // 'match', 'not' => true, 'pattern' => '/^[a-z,.\s-]+$/i',
            // 'message' => 'Không được nhập ký tự đặc biệt',
            // ]
        
        ];
    }

    public function attributeLabels() {
        return [
            'title' => 'Tiêu đề câu hỏi',
            'content' => 'Nội dung câu hỏi',
            'category_id' => 'Danh mục',
            'parent_id' => 'Parent',
        ];
    }

    public function category() {
        $category = Category::find()->all();
        $data = [];
        if (!empty($category)) {
            foreach ($category as $key => $value) {
                $data['parent'] = [];
                foreach ($value->parent as $val) {
                        $data['parent'][] = [
                            'id' => $val['id'],
                            'title' => $val['title']
                        ];
                }
                $data[] = [
                    'id' => $value->id,
                    'title' => $value['title'],
                    'unit' => $value['unit'],
                    'oscillation_unit' => $value['oscillation_unit'],
                    'parent' => $data['parent']
                ];
            }
        }
        return $data;
    }

    public function save() {
            $collection = Yii::$app->mongodb->getCollection('question');
            $category = Category::findOne($this->category_id);
            $key = array_search($this->product_type, array_column($category->parent, 'id'));
            $product_type = $category->parent[$key];
            $data = [
                'title' => $this->title,
                'slug' =>  Constant::slug($this->title),
                'content' => $this->content,
                'user' => [
                    'id' => \Yii::$app->user->id,
                    'username' => \Yii::$app->user->identity->username,
                    'fullname' => \Yii::$app->user->identity->fullname
                ],
                'category' => [
                    'id' => $category->id,
                    'title' => $category->title,
                    'slug' => $category->slug,
                ],
                'product_type' => [
                    'id' => $product_type['id'],
                    'title' => $product_type['title'],
                    'slug' => $product_type['slug'],
                ],
                'view' => 0,
                'user_vote'=>[],
                'vote'=> 0,
                'total_answer' => 0, 
                'updated_at' => time(),
            ];
            
            if($this->id){
                $collection->update(['_id'=>$this->id],$data);
                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'admin',
                    'content' => '<b>'.\Yii::$app->user->identity->fullname.'<b> vừa sửa câu hỏi ở forum.',
                    'url' => Yii::$app->setting->get('siteurl_backend').'/forum/filter?id='.$this->id,
                    'status' => 0,
                    'created_at' => time()
                ]);
                return $this->id;
            }else{
                $id = $collection->insert(array_merge($data,['created_at' => time()]));
                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'admin',
                    'content' => '<b>'.\Yii::$app->user->identity->fullname.'<b> vừa đăng câu hỏi ở forum.',
                    'url' => Yii::$app->setting->get('siteurl_backend').'/forum/filter?id='.$id,
                    'status' => 0,
                    'created_at' => time()
                ]);
                return $id;
            }

    }


}

?>