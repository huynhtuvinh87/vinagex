<?php

namespace common\models\searchs;

use common\models\Comment;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CommentSearch extends Comment {

    public $keywords;
    public $seller;
    public $id;
    public $pageSize = 20;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['keywords', 'status','id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function getCount($status = '') {
        if ($status) {
            return Comment::find()->where(['status' => $status])->count();
        } else {
            return Comment::find()->count();
        }
    }

    public function getCountSeller($status = '') {
        if ($status) {
            return Comment::find()->where(['status' => $status, 'product.owner.id' => \Yii::$app->user->id])->count();
        } else {
            return Comment::find(['product.owner.id' => \Yii::$app->user->id])->count();
        }
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Comment::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]],
            'pagination' => [
                'defaultPageSize' => $this->pageSize
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // find by trainer code
        if (!empty($this->keywords)) {
            $lowerKeywords = strtolower($this->keywords);
            $query->orFilterWhere(['email' => $this->keywords]);
            $query->orFilterWhere(['name' => $this->keywords]);
            $query->orFilterWhere(['content' => $this->keywords]);
        }


        // find by trainer code
        if (!empty($this->status)) {

            $query->andFilterWhere(['status' => (int) $this->status]);
        }
        if (!empty($this->seller)) {
            $query->andFilterWhere(['product.owner.id' => $this->seller]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            '_id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->orderBy('id DESC');

        return $dataProvider;
    }

}
