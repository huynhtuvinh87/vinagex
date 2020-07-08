<?php

namespace common\models\searchs;

use common\models\Page;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PageSearch represents the model behind the search form about `common\modules\Post\models\Post`.
 */
class PageSearch extends Page {

    public $keywords;
    public $widget;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['keywords', 'widget'], 'safe'],
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
        $query = Page::find();
        $query->orderBy('created_at DESC');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['_id'=>SORT_DESC]],
            'pagination' => [
                'defaultPageSize' => 10
            ],
        ]);
        // find by trainer code
        if (!empty($params['keywords'])) {
            $keyword = strtolower($params['keywords']);
            $query->where(['like', 'title', $keyword]);
        }
        
        if (!empty($params['widget'])) {
        
            $query->where(['=', 'widget', (int)$params['widget']]);
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'content', $this->content])
                ->andFilterWhere(['like', 'slug', $this->slug]);

        $query->orderBy('id DESC');

        return $dataProvider;
    }

}
