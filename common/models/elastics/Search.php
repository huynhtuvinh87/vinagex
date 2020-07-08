<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models\elastics;

use common\models\elastics\Elastic;
use yii\base\Model;
use yii\elasticsearch\ActiveDataProvider;
use yii\elasticsearch\Query;

class Search extends Model {

    public function search($params) {
        $query = new Query();
        $query->source('*');
        $query->from(Elastic::index(), Elastic::type())->limit(10);
        $query->fields = [
            'id',
            'title',
         
        ];
        $command = $query->createCommand();
        $rows = $command->search();
        var_dump($rows);
        exit;
        $searchs = $params['keywords'];
        $elastic = new Elastic;
        $result = $elastic::find()->query([
            "match" => ["province.id" => '5aefcdbefd32570601faa8e2'],
            "match" => ["title" => 'Đu']
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $result,
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);



        return $dataProvider;
    }

}
