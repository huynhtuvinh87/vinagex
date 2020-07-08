<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;
use common\models\Category;
use common\components\Constant;
use common\models\Review;
use common\models\Setting;
use common\models\Province;
use yii\mongodb\Query;
use common\models\ProductOrder;

class Product extends ActiveRecord {

    public $_setting;

    const SALE_DEAL = 1;
    const SALE_FRAME = 2;
    const TRANSPOST_1 = 1;
    const TRANSPOST_2 = 2;
    const TIMETOSELL_1 = 1;
    const TIMETOSELL_2 = 2;
    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_NOACTIVE = 3;
    const STATUS_BLOCK = 4;

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'product';
    }

    public function attributes() {
        return [
            '_id',
            'owner',
            'province',
            'title',
            'slug',
            'keyword',
            'category',
            'product_type',
            'description',
            'content',
            'images',
            'price_by_area',
            'quantity',
            'number',
            'approx',
            'classify',
            'unit',
            'certification',
            'price',
            'weight',
            'review',
            'price_deal',
            'price_retail',
            'price_frame',
            'form_of_transport',
            'time_to_sell',
            'approx',
            'classify',
            'time_begin',
            'time_end',
            'status',
            'error',
            'quantity_min',
            'quantity_stock',
            'quantity_stock_temp',
            'quantity_purchase',
            'quantity_purchase_total',
            'price_type',
            'note_cancel',
            'show_process',
            'created_at',
            'updated_at'
        ];
    }

    public function init() {
        $this->_setting = Setting::findOne(['key' => 'config']);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['slug'], 'string'],
        ];
    }

    public function attributeLabels() {
        return [
            'title' => 'Tên sản phẩm',
            'content' => 'Giới thiệu sản phẩm',
            'description' => 'Mô tả sản phẩm',
            'images' => 'Hình ảnh sản phẩm',
            'time_begin' => 'Ngày bán đầu bán',
            'time_end' => 'Ngày kết thúc ',
            'unit_of_calculation' => 'Đơn vị tính',
            'price_by_area' => 'Khu vực bán',
            'price' => 'Giá sản phẩm',
            'quantity' => 'Số lượng tối thiểu',
            'category_id' => 'Danh mục sản phẩm',
            'certification' => 'Chứng nhận',
            'sale' => 'Hình thức bán',
            'form_of_transport' => 'Hình thức vận chuyển',
            'time_to_sell' => 'Thời gian bán',
            'status' => 'Trạng thái',
            'weight' => 'Trọng lượng',
            'quantity_stock' => 'Số lượng trong kho',
            'created_at' => 'Ngày đăng'
        ];
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'slugBehavior' => [
                'class' => \common\components\SluggableBehavior::className(),
                'attribute' => 'title'
            ],
        ]);
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function getUrl() {
        return \Yii::$app->setting->get('siteurl') . '/' . $this->slug . '-' . $this->id;
    }

    public function status() {
        return [
            self::STATUS_PENDING => '',
            self::STATUS_ACTIVE => 'Đã duyệt',
            self::STATUS_NOACTIVE => 'Chưa duyệt',
            self::STATUS_BLOCK => 'Đã Khóa'
        ];
    }

    public function getCountdown() {
        if ($this->time_to_sell == Product::TIMETOSELL_2) {
            return TRUE;
        }
        return FALSE;
    }

    public function number() {
        return (new Query)->from('product_order')->where(['product.id' => $this->id])->andWhere(['<>', 'status', Constant::STATUS_ORDER_PENDING])->count();
    }

    public function quantity() {
        $query = (new Query)->from('product_order')->where(['product.id' => $this->id, 'status' => (int) Constant::STATUS_ORDER_SENDING])->all();
        if ($query) {
            $sum = 0;
            foreach ($query as $value) {
                $sum += $value['product']['quantity'];
            }
            return $sum;
        }
        return 0;
    }

    public static function active() {
        return self::find()->where(['status' => (int)Constant::STATUS_ACTIVE, 'province.id' => \Yii::$app->province->getId()])->andWhere(['owner.status' => (int)Constant::STATUS_ACTIVE]);
    }

    public function getProvinces() {
        return Province::find()->where(['_id' => $this->province])->all();
    }

    public function getUser() {
        return User::findOne($this->owner['id']);
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getCountReview() {
        return Review::find()->where(['product.id' => $this->id, 'status' => Constant::STATUS_ACTIVE])->count();
    }

    public function getRating() {
        return ($this->countstar * 5) > 0 ? $this->countstar * 10 : 0;
    }

    public function countstar($star) {
        return Review::find()->where(['product.id' => $this->id, 'star' => $star, 'status' => Constant::STATUS_ACTIVE])->count();
    }

    public function getTotalReview() {
        $star1 = $this->countstar(1);
        $star2 = $this->countstar(2);
        $star3 = $this->countstar(3);
        $star4 = $this->countstar(4);
        $star5 = $this->countstar(5);
        if (($star1 + $star2 + $star3 + $star4 + $star5) > 0) {
            $total = (($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1)) / ($star1 + $star2 + $star3 + $star4 + $star5);
        } else {
            $total = 0;
        }
        return round($total, 2);
    }

    public function getMinimum() {
        if (!empty($this->approx)) {
            $qtt = [];
            foreach ($this->approx as $value) {
                $qtt[] = $value['quantity_min'];
            }
            return min($qtt);
        } elseif (!empty($this->classify)) {
            $count = count($this->classify);
            $qtt[] = [];
            for ($i = 0; $i < $count; $i++) {
                if (!empty($this->classify[$i]['frame'])) {
                    foreach ($this->classify[$i]['frame'] as $k => $val) {
                        $qtt[] = $val['quantity_min'];
                        $qtt[] = $val['quantity_max'];
                    }
                } else {
                    $qtt[] = $this->classify[$i]['quantity'];
                }
            }
            return min($qtt);
        } else {
            return $this->quantity;
        }
    }

    public function getError() {
        return [
            1 => 'Tiêu đề không hợp lý',
            2 => 'Hình ảnh không thực thế',
            3 => 'Mô tả không hợp lý',
            4 => 'Gía không hợp lý',
            5 => 'Số lượng không hợp lý',
            6 => 'Thời gian bán không hợp lý'
        ];
    }

    public function getLike() {
        $query = (new Query)->from('wishlist')->where(['user_id' => \Yii::$app->user->id, 'product_id' => $this->id])->one();
        if ($query) {
            return TRUE;
        }
        return FALSE;
    }

    public function showProcess() {
        $count = (new Query)->from('product_image')->where(['product.id' => $this->id,'status'=>Constant::STATUS_ACTIVE])->count();
        if ($count > 0) {
            return TRUE;
        }
        return FALSE;
    }

}
