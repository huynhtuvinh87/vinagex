<?php

namespace common\models;

use yii\mongodb\ActiveRecord;
use common\models\Question;

/**
 * 
 */
class Answer extends ActiveRecord {

    public static function collectionName() {
        return 'answer';
    }

    public function attributes() {
        return [
            '_id',
            'content',
            'question',
            'user',
            'parent_answer',
            'user_vote',
            'vote',
            'created_at',
            'updated_at',
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function countVote() {
        $question = $this::findOne(['_id' => $this->id]);
        $count = 0;
        foreach ($question['user_vote'] as $value) {
            $count = $count + 1;
        }
        return $count;
    }

    public function vote() {
        $vote = $this::find()->where(['_id' => $this->id, 'user_vote.id' => \Yii::$app->user->id])->count();
        return $vote;
    }

    public function countQuestion($id){
        return Question::find()->where(['user.id'=>$id])->count();
    }

    public function countAnswerByUser($id){
        return $this::find()->where(['user.id'=>$id])->count();
    }

}

?>