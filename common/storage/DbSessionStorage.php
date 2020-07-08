<?php

namespace common\storage;

use common\components\CartItem;
use yii\mongodb\Query;
use Yii;
use common\models\Product;

class DbSessionStorage implements StorageInterface {

    /**
     * @var array $params Custom configuration params
     */
    private $params;

    /**
     * @var integer $userId
     */
    private $userId;

    /**
     * @var SessionStorage $sessionStorage
     */
    private $sessionStorage;

    public function __construct(array $params) {
        $this->params = $params;
        $this->userId = Yii::$app->user->id;
        $this->sessionStorage = new SessionStorage($this->params);
    }

    /**
     * @return CartItem[]
     */
    public function load() {
        if (Yii::$app->user->isGuest) {
            return $this->sessionStorage->load();
        }
        $this->moveItems();
        return $this->loadDb();
    }

    /**
     * @param CartItem[] $items
     * @return void
     */
    public function save(array $items) {
        if (Yii::$app->user->isGuest) {
            $this->sessionStorage->save($items);
        } else {
            $this->moveItems();
            $this->saveDb($items);
        }
    }

    /**
     *  Moves all items from session storage to database storage
     * @return void
     */
    private function moveItems() {
        if ($sessionItems = $this->sessionStorage->load()) {
            $items = array_merge($this->loadDb(), $sessionItems);
            $this->saveDb($items);
            $this->sessionStorage->save([]);
        }
    }

    /**
     * Load all items from the database
     * @return CartItem[]
     */
    private function loadDb() {
        $rows = (new Query())->from('cart')->where(['user_id' => $this->userId])->all();
        $items = [];
        foreach ($rows as $row) {
            $product_id = explode('type', $row['product_id']);
            $product = Product::find()->where(['_id' => $product_id[0]])->limit(1)->one();
            if ($product) {
                $items[(string) $product['_id'].'type'.$row['type']] = new CartItem($product, $row['quantity'], $row['type'], $this->params);
            }
        }
        return $items;
    }

    /**
     * Save all items to the database
     * @param CartItem[] $items
     * @return void
     */
    private function saveDb($items) {
        Yii::$app->mongodb->getCollection('cart')->remove(['user_id' => $this->userId]);
        $data = array_map(function (CartItem $item) {
            return [
                'user_id' => $this->userId,
                'product_id' => $item->getId(),
                'quantity' => $item->getQuantity(),
                'type' => $item->getType()
            ];
        }, $items);
        foreach (array_values($data) as $value) {
            Yii::$app->mongodb->getCollection('cart')->insert($value);
        }
    }

}
