<?php

namespace common\models\searchs;

use common\models\Quotations;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class QuotationSearch extends Quotations {

    public $keywords;
    public $pageSize = 20;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['keywords', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Quotations::find();
        $query->orderBy('created_at DESC');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            $query->orFilterWhere(['fullname' => $this->keywords]);
            $query->orFilterWhere(['phone' => $this->keywords]);
            $query->orFilterWhere(['content' => $this->keywords]);
        }
        // find by trainer code
        if (!empty($this->status)) {

            $query->andFilterWhere(['status' => (int) $this->status]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->orderBy('id DESC');

        return $dataProvider;
    }

}
