<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\mongodb\Query;

class AjaxController extends Controller {

    public function init() {
        parent::init();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function actionDeleteimage() {
        $filepath = \Yii::getAlias("@cdn/web/" . $_POST['path']);
        return unlink($filepath);
    }

    public function actionUpload() {
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['file']));
        if (!file_exists(\Yii::getAlias("@cdn/web/images/members/member_" . \Yii::$app->user->id))) {
            mkdir(\Yii::getAlias("@cdn/web/images/members/member_" . \Yii::$app->user->id), 0777, true);
        }
        $name = uniqid() . '.png';
        $filepath = \Yii::getAlias("@cdn/web/images/members/member_" . \Yii::$app->user->id) . '/' . $name;
        file_put_contents($filepath, $data);
        list($width, $height, $type, $attr) = getimagesize($filepath);
        return [
            'src' => Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/members/member_' . \Yii::$app->user->id . '/' . $name . '&size=210x190',
            'path' => 'images/members/member_' . \Yii::$app->user->id . '/' . $name
        ];
    }

    public function actionAvatar() {
        if (file_exists(\Yii::getAlias("@cdn/web/images/avatars/avatar_" . \Yii::$app->user->id . '.png'))) {
            unlink(\Yii::getAlias("@cdn/web/images/avatars/avatar_" . \Yii::$app->user->id . '.png'));
        }
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['file']));
        $filepath = \Yii::getAlias("@cdn/web/images/avatars/avatar_" . \Yii::$app->user->id . '.png');
        file_put_contents($filepath, $data);
        list($width, $height, $type, $attr) = getimagesize($filepath);
        if (file_exists(\Yii::getAlias("@cdn/web/images/avatars/avatar_" . \Yii::$app->user->id . '.png'))) {
            Yii::$app->mongodb->getCollection('user')->update(['_id' => Yii::$app->user->id], ['$set' => ['avatar' => 'images/avatars/avatar_' . \Yii::$app->user->id . '.png']]);
            return [
                'src' => $_POST['file']
            ];
        } else {
            return ['error' => Yii::t('frontend', 'Tải ảnh đại diện không thành công!')];
        }
    }

    public function actionDistrict($id) {
        $model = Yii::$app->province->getDistricts($id);
        return $model;
    }

    public function actionWard($id) {
        $model = Yii::$app->province->getWards($id);
        return $model;
    }

    public function actionParent($id) {
        $query = (new Query)->from('category')->where(['_id' => $id])->one();
        return $this->renderAjax('parent', ['model' => $query]);
    }

}
