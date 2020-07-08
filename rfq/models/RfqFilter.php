<?php

namespace rfq\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;
use common\components\Constant;

class RfqFilter extends Model {

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
        $query = (new Query)->from('rfq')->where(['status' => Constant::STATUS_PENDING])->orderBy('created_at DESC');

        if (!empty($params['keywords'])) {
            $query->andWhere(['or',
                ['like', 'slug', Constant::slug($params['keywords'])],
                ['like', 'title', strtolower($params['keywords'])],
                ['like', 'product_type.slug', Constant::slug($params['keywords'])],
            ]);
        }

        if (!empty($params['category'])) {
            $query->andWhere(['or',
                        ['==', 'category.id', $params['category']],
                        ['==', 'product_type.id', $params['category']],
                    ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $dataProvider;
    }

}
