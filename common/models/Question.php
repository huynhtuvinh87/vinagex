<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Query;

/**
 * 
 */
class Question extends ActiveRecord {

    public static function collectionName() {
        return 'question';
    }

    public function attributes() {
        return [
            '_id',
            'title',
            'slug',
            'content',
            'user',
            'category',
            'product_type',
            'view',
            'user_vote',
            'vote',
            'total_answer',
            'created_at',
            'updated_at',
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function countLike() {
        return (new Query)->from('like')->where(['question_id' => $this->id])->count();
    }

    public function like($question_id, $user_id) {
        return (new Query)->from('like')->where(['question_id' => $question_id, 'user_id' => $user_id])->count();
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

    public function countQuestion($id) {
        return $this::find()->where(['user.id' => $id])->count();
    }

    public function countAnswerByUser($id) {
        return Answer::find()->where(['user.id' => $id])->count();
    }

    public function newQuestion() {
        return $this::find()->limit(10)->orderBy(['_id' => SORT_DESC])->all();
    }

    public function ratingQuestion() {
        return $this::find()->where(['>', 'vote', 0])->limit(10)->orderBy(['vote' => SORT_DESC])->all();
    }

    public function answerQuestion() {
        return $this::find()->where(['>', 'total_answer', 0])->limit(10)->orderBy(['total_answer' => SORT_DESC])->all();
    }

}

?>