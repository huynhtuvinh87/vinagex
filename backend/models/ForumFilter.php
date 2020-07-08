<?php

namespace backend\models;

use common\models\Question;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;

class ForumFilter extends Model {

    public function init() {
        parent::init();
    }

    /**
     * @huynhtuvinh87@gmail.com
     */
    public function rules() {
        return [
            [['keywords'], 'default'],
                // ['keywords',
                // 'match', 'not' => true, 'pattern' => '/[^a-zA-Z_-]/',
                // 'message' => 'Không được nhập ký tự đặc biệt',
                // ]
        ];
    }

    /**
     * @huynhtuvinh87@gmail.com
     * Filter search
     */
    public function fillter($params) {
        $query = Question::find()->orderBy(['created_at' => SORT_DESC]);

        if (!empty($params['keywords'])) {
            $query->andWhere(['like', 'title', strtolower($params['keywords'])]);
        }

        if (!empty($params['id'])) {
            $query->andWhere(['_id' => $params['id']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);
        return $dataProvider;
    }

}
