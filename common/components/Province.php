<?php

namespace common\components;

use yii\base\BaseObject;
use yii\mongodb\Query;
use common\models\District;

class Province extends BaseObject {

    private $items;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
    }

    public function getItems() {
        $query = (new Query)->from('province')->all();
        return $query;
    }

   

    public function getProvince($id) {
        $query = (new Query)->from('province')->where(['_id' => $id])->one();
        return $query;
    }

    public function getDistricts($id) {
        $query = District::find()->where(['province_id' => $id])->all();
        return $query;
    }

    public function getDistrict($id) {
        $query = (new Query)->from('district')->where(['_id' => $id])->one();
        return $query;
    }

    public function getWards($id) {
        $query = (new Query)->from('district')->where(['_id' => $id])->one();
        return $query['ward'];
    }

    public function getWard($slug) {
        $query = (new Query)->from('district')->where(['ward.slug' => $slug])->one();
        $key = array_search($slug, array_column($query['ward'], 'slug'));
        return $query['ward'][$key];
    }

}
