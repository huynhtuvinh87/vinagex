<?php

namespace company\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\mongodb\Query;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class SiteController extends Controller {

    public function init() {
        parent::init();
    }


    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    public function actionIndex() {
        $params = Yii::$app->request->getQueryParams();
        $query = (new Query())->from('company')->orderBy(['created_at' => SORT_DESC]);
        if (!empty($params['category'])) {
            $query->andFilterWhere(['type' => (int)$params['category']]);
        }
        if (!empty($params['keyword'])) {
            $query->andFilterWhere(['or',
                ['like', 'name', $params['keyword']],
                ['like', 'address', $params['keyword']],
            ]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 50
            ],
        ]);
        $this->view->title = 'Tra cứu danh bạ công ty';
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionImport() {
//        $data = \moonland\phpexcel\Excel::import(\Yii::getAlias("@backend/web/files/Data_Vietgap.xlsx"), [
//                    'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
//                    'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
//        ]);
//        foreach ($data as $value) {
//            if (!empty($value)) {
//                foreach ($value as $val) {
//                    Yii::$app->mongodb->getCollection('company')->insert([
//                        'type' => 1,
//                        'name' => $val['name'],
//                        'phone' => $val['phone'],
//                        'address' => $val['address'],
//                        'code' => $val['code'],
//                        'certification' => 'Việt Gap',
//                        'product' => $val['product'],
//                        'created_at' => time(),
//                        'updated_at' => time()
//                    ]);
//                }
//            }
//        }

        $data = \moonland\phpexcel\Excel::import(\Yii::getAlias("@company/web/files/Nông Nghiệp - Tư Vấn.xlsx"), [
                    'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
                    'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
        ]);
        foreach ($data as $value) {
            Yii::$app->mongodb->getCollection('company')->insert([
                'type' => 4,
                'name' => $value['CÔNG TY'],
                'phone' => $value['SĐT'],
                'email' => $value['EMAIL'],
                'website' => $value['WEBSITE'],
                'address' => $value['ĐỊA CHỈ'],
                'product' => 'Tư vấn nông nghiệp',
                'created_at' => time(),
                'updated_at' => time()
            ]);
        }
    }


}
