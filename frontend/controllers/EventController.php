<?php

namespace frontend\controllers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\base\Event;
use yii\mongodb\Query;

class EventController extends \yii\base\Controller {

    const EVENT_DEMO = 'demoEvent';

    public function actionGlobal() {
        $event = new \common\events\SendMailEvent(['fromName' => 'Vinagex', 'fromAddress' => "huynhtuvinh87@gmail.com", 'data' => 651616619]);
        $this->on(self::EVENT_DEMO, [$this, 'sendmail'], $event);
        $this->trigger(self::EVENT_DEMO, $event);
        $this->off(self::EVENT_DEMO);
    }

    public function sendmail(Event $event) {
        echo $event->data->fromName;
    }

}
