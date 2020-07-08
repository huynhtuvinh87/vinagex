<?php

namespace forum\models;

use Yii;
use yii\base\Model;
use common\models\Question;
/**
 * 
 */
class AnswerForm extends Model {

        public $id;
        public $question_id;
        public $content;
        public $answer_id;
        public $content_answer;
        public $question;
        public $user;
        public $parent_answer;
        public $created_at;
        public $updated_at;

    public function init() {

    }

    public function rules() {
        return [
            [['content'], 'required', 'message' => '{attribute} Không được để trống'],
            [['content_answer'], 'required', 'message' => '{attribute} Không được để trống'],
            // ['content',
            // 'match', 'not' => true, 'pattern' => '/^[a-z,.\s-]+$/i',
            // 'message' => 'Không được nhập ký tự đặc biệt',
            // ]
        ];
    }

    public function attributeLabels() {
        return [
            'content' => 'Nội dung câu hỏi',
        ];
    }

    public function save() {
        if(!empty($this->answer_id)){
            $collection = Yii::$app->mongodb->getCollection('answer');
            $id =  (string) new \MongoDB\BSON\ObjectID();
            $collection->update(['_id'=>$this->answer_id],['$push'=>['parent_answer'=>[
                'id' =>$id,
                'content' => $this->content_answer,
                'user_id' => \Yii::$app->user->id,
                'fullname' => \Yii::$app->user->identity->fullname,
                'username' => \Yii::$app->user->identity->username,
                'created_at' => time(),
                'updated_at' =>time()
            ]]]);

            return $id;

        }else if(!empty($this->question_id)){

            $collection = Yii::$app->mongodb->getCollection('answer');
            $qt = Question::findOne($this->question_id); 
            Yii::$app->mongodb->getCollection('question')->update(['_id'=>$this->question_id],['total_answer'=>$qt->total_answer + 1]);
            $data = [
                'content' => $this->content,
                'question' => [
                    'id'=>(string)$qt['_id'],
                    'title'=>$qt['title'],
                    'user_id'=>$qt['user']['id']
                    ],
                'user' => [
                        'id' => \Yii::$app->user->id,
                        'username' => \Yii::$app->user->identity->username,
                        'fullname' => \Yii::$app->user->identity->fullname
                    ],
                'parent_answer' => [],
                'user_vote' => [],
                'vote' => 0,
                'created_at' => time(),
                'updated_at' => time(),
            ];

            $id = $collection->insert($data);

            return $id;
        }
    }

}

?>