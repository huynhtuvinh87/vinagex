<?php

namespace frontend\models;

use Yii;
use common\models\Product;
use common\models\Category;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;
use common\components\Constant;

class ProductFilter extends Model {

    const CERITERIA_1 = 1;
    const CERITERIA_2 = 2;
    const CERITERIA_3 = 3;
    const CERITERIA_4 = 4;

    public $keywords;
    public $params;

    public function init() {
        parent::init();
        $this->attributes = $this->params;
    }

    /**
     * @huynhtuvinh87@gmail.com
     */
    public function rules() {
        return [
            [['keywords'], 'default'],
        ];
    }

    /**
     * @huynhtuvinh87@gmail.com
     * List category
     */
    public function category() {
        $category = Category::find()->orderBy(['order' => SORT_ASC])->all();
        $data = [];
        if (!empty($category)) {
            foreach ($category as $key => $value) {
                $array = [];
                if (!empty($value->parent)) {
                    foreach ($value->parent as $val) {
                        $array[] = [
                            'id' => $val['id'],
                            'title' => $val['title'],
                            'slug' => $val['slug'],
                            'count' => Product::active()->andWhere(['product_type.id' => $val['id']])->count()
                        ];
                    }
                }

                $data[] = [
                    'id' => $value->id,
                    'title' => $value['title'],
                    'slug' => $value['slug'],
                    'parent' => $array,
                    'count' => Product::active()->andWhere(['category.id' => $value->id])->count()
                ];
            }
        }
        return $data;
    }

    public function getCategory() {
        if (!empty($_GET['type'])) {
            $category = (new Query())->select(['slug', 'title'])->from('category')->where(['parent.slug' => $_GET['type']])->one();
            return $category;
        }
    }

    public function sell() {
        return[
            Product::TIMETOSELL_1 => Yii::t('common', 'Sản phẩm có sẵn'),
            Product::TIMETOSELL_2 => Yii::t('common', 'Sản phẩm đặt trước'),
        ];
    }

    /**
     * @huynhtuvinh87@gmail.com
     * List criteria
     */
    public function criteria() {
        return[
            self::CERITERIA_2 => Yii::t('frontend', 'Đã đóng bảo hiểm'),
            self::CERITERIA_3 => Yii::t('frontend', 'Sắp giao hàng'),
            self::CERITERIA_4 => Yii::t('frontend', 'Giá tốt nhất')
        ];
    }

    public function classify() {
        return[
            1 => Yii::t('common', 'Loại') . ' 1',
            2 => Yii::t('common', 'Loại') . ' 2',
            3 => Yii::t('common', 'Loại') . ' 3',
            'loại 4' => Yii::t('common', 'Loại') . ' 4',
        ];
    }

    /**
     * @huynhtuvinh87@gmail.com
     * List certification
     */
    public function certification() {
        $query = new Query();
        $query->from('certification');
        $rows = $query->all();
        $data = [];
        foreach ($rows as $value) {
            $data[] = [
                'id' => (string) $value['_id'],
                'name' => $value['name'],
                'count' => Product::find()->where(['in', 'certification.id', (string) $value['_id']])->count()
            ];
        }
        return $data;
    }

    /**
     * @huynhtuvinh87@gmail.com
     * Filter search
     */
    public function fillter($params) {
        $query = (new Query)->from('product')->where(['owner.status' => (int) Constant::STATUS_ACTIVE])->orderBy(['created_at' => SORT_DESC]);
        if (!empty($params['category'])) {
            $query->andFilterWhere(['category.id' => $params['category']])->orFilterWhere(['category.slug' => $params['category']]);
        }
        if (!empty($params['type'])) {
            $query->andFilterWhere(['product_type.id' => $params['type']]);
        }
        if (!empty($params['keywords'])) {
            $query->andFilterWhere(['like', 'title', strtolower($params['keywords'])])->orFilterWhere(['like', 'slug', strtolower($params['keywords'])])->orFilterWhere(['like', 'keyword', strtolower($params['keywords'])]);
        }
        if (!empty($params['certification'])) {
            $query->andFilterWhere(['in', 'certification.id', $params['certification']]);
        }
        if (!empty($params['classify'])) {
            $query->andFilterWhere(['classify.id' => (int) $params['classify']]);
        }
        if (!empty($params['from_price'])) {
            $query->andFilterWhere(['>=', 'price.min', (int) $params['from_price']]);
        }
        if (!empty($params['to_price'])) {
            $query->andFilterWhere(['<=', 'price.min', (int) $params['to_price']]);
        }
        if (!empty($params['quantity_min'])) {
            $query->andFilterWhere(['>=', 'quantity', (int) $params['quantity_min']]);
        }
        if (!empty($params['quantity_max'])) {
            $query->andFilterWhere(['<=', 'quantity', (int) $params['quantity_max']]);
        }
        if (!empty($params['date'])) {
            $date = Constant::convertTime($params['date']);
            $query->andFilterWhere(['<=', 'time_begin', $date])->andFilterWhere(['>=', 'time_end', $date]);
        }
        if (!empty($params['sort'])) {
            switch ($params['sort']) {
                case 'new':
                    $query->orderBy(['created_at' => SORT_DESC]);
                    break;
                case 'price-asc':
                    $query->orderBy(['price.min' => SORT_ASC]);
                    break;
                default:
                    $query->orderBy(['price.max' => SORT_DESC]);
                    break;
            }
        }
        if (!empty($params['sell'])) {
            $query->andFilterWhere(['time_to_sell' => (int) $params['sell']]);
        }
        $query->andFilterWhere(['status' => (int) Constant::STATUS_ACTIVE, 'province.id' => \Yii::$app->province->getId()]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 24
            ],
        ]);

        return $dataProvider;
    }

}
