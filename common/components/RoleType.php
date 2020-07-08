<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components;

use yii\base\Component;
use common\components\Constant;

class RoleType extends Component {

    public function isSeller() {
        if (\Yii::$app->user->identity->role == Constant::ROLE_SELLER) {
            return TRUE;
        }
        return FALSE;
    }

    public function isMember() {
        if (\Yii::$app->user->identity->role == Constant::ROLE_MEMBER) {
            return TRUE;
        }
        return FALSE;
    }

    public function isAdmin() {
        if (\Yii::$app->user->identity->role == Constant::ROLE_ADMIN) {
            return TRUE;
        }
        return FALSE;
    }

}
