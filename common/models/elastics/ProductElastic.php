<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models\elastics;

use yii\base\Model;
use common\models\elastics\Elastic;

/**
 * ProductElastic
 */
class ProductElastic extends Model {

    public function save($data) {
        $elastic = new Elastic();
        $elastic->product_id = (string)$data['id'];
        $elastic->title = (string)$data['title'];
        $elastic->slug = (string)$data['slug'];
        $elastic->content = (string)$data['content'];
        $elastic->owner = $data['owner'];
        $elastic->category = $data['category'];
        $elastic->product_type = $data['product_type'];
        $elastic->price_by_area = (string)$data['price_by_area'];
        $elastic->unit = (string)$data['unit'];
        $elastic->certification = $data['certification'];
        $elastic->sale = (string)$data['sale'];
        $elastic->images = $data['images'];
//        $elastic->weight = $data['weight'];
        $elastic->province = $data['province'];
        $elastic->status = (string)$data['status'];
        $elastic->insert();
    }

}
