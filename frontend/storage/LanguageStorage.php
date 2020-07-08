<?php

namespace frontend\storage;

use Yii;
use yii\helpers\Json;

class LanguageStorage {

    /**
     * @var object $id
     */
    private $code;

    /**
     * @var object $product
     */
    private $name;

    public function __construct() {
        $cookies = Yii::$app->request->cookies;
        if ($cookies->has('language')) {
            $language = Json::decode($cookies->getValue('language'));
            $this->code = $language['code'];
            $this->name = $language['name'];
        } else {
            $this->code = 'vi';
            $this->name = 'Việt Nam';
        }
    }

    /**
     * Returns the id of the item
     * @return integer
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Returns the quantity of the item
     * @return integer
     */
    public function getName() {
        return $this->name;
    }

}
