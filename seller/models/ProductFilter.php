<?php

namespace seller\models;

use Yii;
use yii\base\Model;
use common\models\Product;
use yii\data\ActiveDataProvider;
use common\components\Constant;

class ProductFilter extends Model {

    public $keywords;
    public $id;

    public function init() {
        parent::init();
    }

    /**
     * @huynhtuvinh87@gmail.com
     */
    public function rules() {
        return [
            [['keywords','id'], 'default'],
        ];
    }
/**
     * @inheritdoc
     */

    public function fillter($params) {
        $query = Product::find();
        if (!empty($params['keywords'])){
            $query->andWhere(['title'=>(string)$params['keywords']]);
        }
         if (!empty($params['id'])){
            $query->andWhere(['_id'=>(string)$params['id']]);
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
