<?php

namespace common\events;

use yii\mongodb\Query;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SendMailEvent extends \yii\base\Event {

    public $fromName;
    public $fromAddress;
    public $result;
}
