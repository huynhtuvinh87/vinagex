<?php

namespace frontend\storage;

use yii\helpers\Json;
use yii\web\Cookie;
use Yii;

class CookieStorage implements StorageInterface {

    /**
     * @var array $params Custom configuration params
     */
    private $params;

    public function __construct(array $params) {
        $this->params = $params;
    }

    /**
     * @return CartItem[]
     */
    public function load() {
        if ($cookie = Yii::$app->request->cookies->get($this->params['key'])) {
            return array_filter(array_map(function (array $row) {
                        if (isset($row['id'], $row['name'])) {
                            return new ProvinceItem($row['id'], $row['name'], $this->params);
                        }
                        return false;
                    }, Json::decode($cookie->value)));
        }
        return [];
    }

    /**
     * @param CartItem[] $items
     * @return void
     */
    public function save(array $items) {
        Yii::$app->response->cookies->add(new Cookie([
            'name' => $this->params['key'],
            'value' => Json::encode(array_map(function (ProvinceItem $item) {
                                return [
                                    'id' => $item->getId(),
                                    'name' => $item->Name(),
                                ];
                            }, $items)),
            'expire' => time() + $this->params['expire'],
        ]));
    }

}
