<?php

namespace backend\controllers;

use yii;
use backend\components\BackendController;
use common\models\Message;
use yii\data\ActiveDataProvider;
use common\models\Conversation;

/**
 * 
 */
class MessageController extends BackendController {

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Message::find()->where(['order' => 2]),
            'pagination' => [
                'defaultPageSize' => 20
            ],
                ]
        );
        return $this->render('index', [
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionConversation($id) {
        $dataProvider = new ActiveDataProvider([
            'query' => Conversation::find()->where(['owner' => (int) $id,'product_id'=>$_GET['product_id']])->orWhere(['actor' => (int) $id,'product_id'=>$_GET['product_id']]),
            'pagination' => [
                'defaultPageSize' => 20
            ],
                ]
        );

        return $this->render('conversation', [
                    'dataProvider' => $dataProvider,
        ]);
    }

}

?>