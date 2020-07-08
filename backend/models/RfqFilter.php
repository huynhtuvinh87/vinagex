<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;
use common\components\Constant;

class RfqFilter extends Model {

    public $status;
    public $keywords;
    public $id;

    public function init() {
        parent::init();
    }

    /**
     * @huynhtuvinh87@gmail.com
     */
    public function rules() {
        return [
            [['keywords', 'status', 'id'], 'default'],
                // ['keywords',
                // 'match', 'not' => true, 'pattern' => '/[^a-zA-Z_-]/',
                // 'message' => 'Không được nhập ký tự đặc biệt',
                // ]
        ];
    }

    public function status() {
        return [
            0 => 'Tất cả',
            Constant::STATUS_PENDING => 'Duyệt',
            Constant::STATUS_NOACTIVE => 'Chưa duyệt',
            Constant::STATUS_FINISH => 'Đã có hàng',
        ];
    }

    /**
     * @huynhtuvinh87@gmail.com
     * Filter search
     */
    public function filter($params) {
        $query = (new Query)->from('rfq')->orderBy('created_at DESC');
        $this->load($params);
        if (!empty($this->keywords)) {
            $query->andWhere(['or',
                ['like', 'slug', Constant::slug($this->keywords)],
                ['like', 'title', strtolower($this->keywords)],
                ['like', 'product_type.slug', Constant::slug($this->keywords)],
            ]);
        }

        if (!empty($this->status)) {
            $query->andWhere(['==', 'status', (int) $this->status]);
        }

        if (!empty($this->id)) {
            $query->andWhere(['_id' => $this->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $dataProvider;
    }

}
