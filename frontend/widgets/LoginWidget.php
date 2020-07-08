<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use account\models\LoginForm;
use account\models\SignupForm;

class LoginWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        $login = new LoginForm;
        $signup = new SignupForm;
        $signup->login = 1;
        return $this->render('login', ['login' => $login, 'signup' => $signup]);
    }

}
