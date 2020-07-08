<?php

namespace frontend\storage;

use Yii;
use yii\helpers\Json;
use yii\mongodb\Query;
use common\models\District;

class ProvinceStorage {

    /**
     * @var object $id
     */
    private $id;

    /**
     * @var object $product
     */
    private $name;

    public function __construct() {
        $cookies = Yii::$app->request->cookies;
        if ($cookies->has('province')) {
            $province = Json::decode($cookies->getValue('province'));
            $this->id = $province['id'];
            $this->name = $province['name'];
        } else {
            $province = (new Query())->from('province')->where(['key' => 'toan-quoc'])->one();
            $this->id = (string) $province['_id'];
            $this->name = $province['name'];
        }
    }

    /**
     * Returns the id of the item
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Returns the quantity of the item
     * @return integer
     */
    public function getName() {
        return $this->name;
    }

    public function getItems() {
        $query = (new Query)->from('province')->all();
        return $query;
    }

    public function getProvinces() {
        $query = (new Query)->from('province')->where(['not in', 'key', 'toan-quoc'])->all();
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
