<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models\elastics;

use yii\elasticsearch\ActiveRecord;

class Elastic extends ActiveRecord {

    public static function index() {
        return "products";
    }

    public static function type() {
        return "product";
    }

    public function attributes() {
        return [
            'product_id',
            'owner',
            'province',
            'title',
            'slug',
            'category',
            'product_type',
            'content',
            'images',
            'price_by_area',
            'quantity',
            'number',
            'unit',
            'certification',
            'sale',
            'price',
            'weight',
            'review',
            'price_deal',
            'price_retail',
            'price_frame',
            'wholesaleandretail',
            'status',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * @return array This model's mapping
     */
    public static function mapping() {
        return [
            static::type() => [
                'properties' => [
                    'id' => ['type' => 'long'],
                    'product_id' => ['type' => 'long'],
                    'title' => ['type' => 'string'],
                    'content' => ['type' => 'string'],
                    'sale' => ['type' => 'string'],
                    'created_at' => ['type' => 'long'],
                    'updated_at' => ['type' => 'long'],
                    'status' => ['type' => 'long'],
                ]
            ],
        ];
    }

    /**
     * Set (update) mappings for this model
     */
    public static function updateMapping() {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->setMapping(static::index(), static::type(), static::mapping());
    }

    /**
     * Create this model's index
     */
    public static function createIndex() {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->createIndex(static::index(), [
            'settings' => ['index' => ['refresh_interval' => '1s']],
            'mappings' => static::mapping(),
                //'warmers' => [ /* ... */ ],
//'aliases' => [ /* ... */ ],
//'creation_date' => '...'
        ]);
    }

    /**
     * Delete this model's index
     */
    public static function deleteIndex() {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->deleteIndex(static::index(), static::type());
    }

    public static function updateRecord($product_id, $columns) {
        try {
            $record = self::get($book_id);
            foreach ($columns as $key => $value) {
                $record->$key = $value;
            }

            return $record->update();
        } catch (\Exception $e) {
//handle error here
            return false;
        }
    }

    public static function deleteRecord($product_id) {
        try {
            $record = self::get($book_id);
            $record->delete();
            return 1;
        } catch (\Exception $e) {
//handle error here
            return false;
        }
    }

    public static function addRecord(Book $book) {
        $isExist = false;

        try {
            $record = self::get($book->id);
            if (!$record) {
                $record = new self();
                $record->setPrimaryKey($book->id);
            } else {
                $isExist = true;
            }
        } catch (\Exception $e) {
            $record = new self();
            $record->setPrimaryKey($book->id);
        }

        $suppliers = [
            ['id' => '1', 'name' => 'ABC'],
            ['id' => '2', 'name' => 'XYZ'],
        ];

        $record->id = $book->id;
        $record->name = $book->name;
        $record->author_name = $image->author_name;
        $record->status = 1;
        $record->suppliers = $suppliers;

        try {
            if (!$isExist) {
                $result = $record->insert();
            } else {
                $result = $record->update();
            }
        } catch (\Exception $e) {
            $result = false;
//handle error here
        }

        return $result;
    }

}
