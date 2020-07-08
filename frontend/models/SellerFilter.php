<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use yii\mongodb\Query;

/**
 * This is the model class for table "content_meta".
 *
 * @property integer $category
 * @property array $program
 * @property integer $content_id
 * @property string $meta_key
 * @property string $meta_value
 *
 * @property Content $content
 */
class SellerFilter extends Model {

    public $params;

    public function init() {
        parent::init();
        $this->attributes = $this->params;
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function certificate() {
        $query = (new Query)->from('certification')->all();
        $array = [];
        foreach ($query as $value) {
            $array[(string) $value['_id']] = Yii::t('data', 'certification_' . (string) $value['_id']);
        }
        return $array;
    }

    public function province() {
        $query = (new Query)->from('province')->all();
        $array = [];
        foreach ($query as $value) {
            $array[(string) $value['_id']] = $value['name'];
        }
        return $array;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function fillter($params) {
        $query = User::find()->where(['role' => User::ROLE_SELLER, 'public' => User::PUBLIC_ACTIVE, 'status' => User::STATUS_ACTIVE]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 21
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        if (!empty($params['keywords'])) {
            $keyword = strtolower($params['keywords']);
            $query->where(['like', 'fullname', $keyword]);
            $query->orWhere(['like', 'username', $keyword]);
            $query->orWhere(['like', 'garden_name', $keyword]);
            $query->orWhere(['like', 'keyword', $keyword]);
            $query->orWhere(['in', 'category', $keyword]);
        }
        if (!empty($params['certificate'])) {
            $query->andWhere(['certificate.id' => $params['certificate']]);
        }
        if (!empty($params['province'])) {
            $query->andWhere(['province.id' => $params['province']]);
        }
        $query->orderBy(['created_at' => SORT_DESC]);
        return $dataProvider;
    }

}
