<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace forum\widgets;

use Yii;
use yii\base\Widget;
use forum\models\QuestionFilter;
use common\models\Category;

class FilterWidget extends Widget {

    public function init() {
        
    }

    public function run() {
            $category = Category::find()->all();;
            $filter = new QuestionFilter();
            $dataProvider = $filter->fillter(Yii::$app->request->queryParams);
            
            if(!empty(Yii::$app->request->queryParams['vote'])){
                $this->view->title = "Top vote";
            }
            if(!empty(Yii::$app->request->queryParams['news'])){
                $this->view->title = "Mới nhất";
            }
            if(!empty(Yii::$app->request->queryParams['answers'])){
                $this->view->title = "Trả lời nhiều nhất";
            }
            if(!empty(Yii::$app->request->queryParams['category'])){
                $cate_title = Category::findOne(['_id'=>Yii::$app->request->queryParams['category']])['title'];
                $this->view->title = $cate_title;
            }

            if(!empty(Yii::$app->request->queryParams['keywords'])){
                $this->view->title = Yii::$app->request->queryParams['keywords'];
            }
            

            return $this->render('filter', [
                'dataProvider' => $dataProvider,
                'category'=>$category
            ]);
    }

}

?>