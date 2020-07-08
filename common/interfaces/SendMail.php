<?php

namespace common\interfaces;

use yii\base\BaseObject;

class SendMail extends BaseObject implements \yii\queue\JobInterface {

    public function execute($queue) {
        Yii::$app->sendmail->test();
    }

}
