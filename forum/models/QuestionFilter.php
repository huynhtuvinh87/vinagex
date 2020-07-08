<?php

namespace forum\models;

use common\models\Question;
use common\models\Category;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;

class QuestionFilter extends Model {

 


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
     * List category
     */
    public function category() {
        $category = Category::find()->all();
        $data = [];
        if (!empty($category)) {
            foreach ($category as $key => $value) {
                $array = [];
                foreach ($value->parent as $val) {
                    $array[] = [
                        'id' => $val['id'],
                        'title' => $val['title'],
                        'slug' => $val['slug'],
                    ];
                }
                $data[] = [
                    'id' => $value->id,
                    'title' => $value['title'],
                    'slug' => $value['slug'],
                    'parent' => $array
                ];
            }
        }
        return $data;
    }

    public function getCategory() {
            $query = (new Query())->from('category');
        if (!empty($_GET['product_type'])) {
            $query->where(['parent.slug' => $_GET['product_type']]);
        }

        if (!empty($_GET['category'])) {
            $query->where(['_id' => $_GET['category']]);
            
        }
        return $query->one();
    }
    /**
     * @huynhtuvinh87@gmail.com
     * Filter search
     */
    public function fillter($params) {
        $query = Question::find()->orderBy(['created_at'=>SORT_DESC]); 
        if (!empty($params['vote'])) {
            $query->orderBy(['vote'=>SORT_DESC]);
        }
        if (!empty($params['news'])) {
            $query->orderBy(['created_at'=>SORT_DESC]);
        }
        if (!empty($params['answers'])) {
            $query->orderBy(['total_answer'=>SORT_DESC]);
        }
        if (!empty($params['type'])) {
            $query->andWhere(['product_type.slug' => $params['type']]);
        }
        if (!empty($params['keywords'])) {
            $query->andWhere(['like', 'title', strtolower($params['keywords'])]);
        }
        if (!empty($params['category'])) {
            $query->andWhere(['category.id'=>$params['category']]);
        }
        if (!empty($params['product_type'])) {
            $query->andWhere(['=', 'product_type.slug', strtolower($params['product_type'])]);
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
