<?php

namespace rfq\models;

use Yii;
use yii\base\Model;
use common\models\Category;
use yii\mongodb\Query;
use common\components\Constant;

/**
 * 
 */
class RfqForm extends Model {

    public $id;
    public $title;
    public $slug;
    public $content;
    public $category;
    public $product_type;
    public $category_id;
    public $quantity;
    public $unit;
    public $images;
    public $price;
    public $image_error;
    public $date_start;
    public $date_end;
    public $_model;

    public function init() {
        $this->images = [];
        if ($this->id) {
            $query = (new Query)->from('rfq')->where(['_id' => $this->id])->one();
            $this->_model = $query;
            $this->title = $query['title'];
            $this->content = $query['content'];
            $this->category_id = $query['category']['id'];
            $this->product_type = $query['product_type']['id'];
            $this->quantity = $query['quantity'];
            $this->images = $query['images'];
            $this->unit = $query['unit'];
            $this->product_type = $query['product_type']['id'];
            $this->date_start = \Yii::$app->formatter->asDatetime($query['date_start'], "php:d/m/Y");
            $this->date_end = \Yii::$app->formatter->asDatetime($query['date_end'], "php:d/m/Y");
        }
    }

    public function rules() {
        return [
            [['title', 'content', 'date_start', 'date_end'], 'required', 'message' => '{attribute} ' . Yii::t('rfq', 'không được để trống')],
            ['title', 'string', 'max' => 50, 'tooLong' => '{attribute} ' . Yii::t('rfq', 'chỉ được nhập {0} ký tự', '50')],
            [['category_id'], 'required', 'message' => '{attribute} ' . Yii::t('rfq', 'không được để trống')],
            [['unit', 'product_type'], 'default'],
            ['quantity', function ($attribute, $params) {
                    if (($this->unit == "kg") && (int) $this->quantity < 100) {
                        $this->addError('quantity', Yii::t('rfq', 'Số lượng hàng phải được 100 kg trở lên!'));
                    }
                }],
            ['category_id', function ($attribute, $params) {
                    if (empty($this->product_type)) {
                        $this->addError('category_id', Yii::t('rfq', 'Bạn chưa chọn loại hàng nào!'));
                    }
                }],
        ];
    }

    public function attributeLabels() {
        return [
            'title' => Yii::t('rfq', 'Tên sản phẩm'),
            'content' => Yii::t('rfq', 'Mô tả yêu cầu'),
            'category_id' => Yii::t('rfq', 'Danh mục sản phẩm'),
            'parent_id' => 'Parent',
            'quantity' => Yii::t('rfq', 'Số lượng cần mua'),
            'images' => Yii::t('rfq', 'Hình ảnh sản phẩm'),
            'date_start' => Yii::t('rfq', 'Thời gian bắt đầu mua'),
            'date_end' => Yii::t('rfq', 'Thời gian ngưng mua')
        ];
    }

    public function category() {
        $category = Category::find()->all();
        $data = [];
        if (!empty($category)) {
            foreach ($category as $key => $value) {
                $data['parent'] = [];
                foreach ($value->parent as $val) {
                    $data['parent'][] = [
                        'id' => $val['id'],
                        'title' => Yii::t('data', 'sub_category_' . $val['id'])
                    ];
                }
                $data[] = [
                    'id' => $value->id,
                    'title' => $value['title'],
                    'unit' => $value['unit'],
                    'oscillation_unit' => $value['oscillation_unit'],
                    'parent' => $data['parent']
                ];
            }
        }
        return $data;
    }

    public function save() {
        if ($this->validate()) {
            $collection = Yii::$app->mongodb->getCollection('rfq');
            $category = Category::findOne($this->category_id);
            $key = array_search($this->product_type, array_column($category->parent, 'id'));
            $product_type = $category->parent[$key];
            $data = [
                'title' => $this->title,
                'slug' => Constant::slug($this->title),
                'content' => $this->content,
                'owner' => [
                    'id' => \Yii::$app->user->id,
                    'username' => \Yii::$app->user->identity->username,
                    'fullname' => \Yii::$app->user->identity->fullname
                ],
                'category' => [
                    'id' => $category->id,
                    'title' => $category->title,
                    'slug' => $category->slug,
                ],
                'product_type' => [
                    'id' => $product_type['id'],
                    'title' => $product_type['title'],
                    'slug' => $product_type['slug'],
                ],
                'quantity' => (int) $this->quantity,
                'unit' => $this->unit,
                'date_start' => Constant::convertTime($this->date_start),
                'date_end' => Constant::convertTime($this->date_end),
                'created_at' => time(),
                'updated_at' => time(),
            ];
            $img = [];
            if (!empty($_POST['image_temp']) && count($_POST['image_temp']) > 0) {
                if (!file_exists(\Yii::getAlias("@cdn/web/images/rfq/" . \Yii::$app->user->id))) {
                    mkdir(\Yii::getAlias("@cdn/web/images/rfq/" . \Yii::$app->user->id), 0777, true);
                }
                for ($i = 0; $i < count($_POST['image_temp']); $i++) {
                    if (!in_array($_POST['image_temp'][$i], $this->images)) {
                        $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['image_temp'][$i]));
                        $name = uniqid() . '.png';
                        $filepath = \Yii::getAlias("@cdn/web/images/rfq/" . \Yii::$app->user->id) . '/' . $name;
                        file_put_contents($filepath, $file);
                        $img[] = 'images/rfq/' . \Yii::$app->user->id . '/' . $name;
                    } else {
                        $img[] = $_POST['image_temp'][$i];
                    }
                }
            }
            $data['images'] = $img;
            if (!empty($data['images']) or strlen($data['content']) != 182 or $data['title'] != $this->_model['title']) {
                $data['status'] = Constant::STATUS_NOACTIVE;
            } else {
                $data['status'] = Constant::STATUS_PENDING;
            }

            if ($this->id) {
                $collection->update(['_id' => $this->id], $data);
                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'admin',
                    'content' => '<b>' . \Yii::$app->user->identity->fullname . '<b> vừa sửa yêu cầu báo giá.',
                    'url' => Yii::$app->setting->get('siteurl_backend') . '/rfq/index?RfqFilter%5Bid%5D=' . $this->id,
                    'status' => 0,
                    'created_at' => time()
                ]);
                return $this->id;
            } else {
                $id = $collection->insert(array_merge($data, ['created_at' => time()]));
                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'admin',
                    'content' => '<b>' . \Yii::$app->user->identity->fullname . '<b> vừa tạo yêu cầu báo giá.',
                    'url' => Yii::$app->setting->get('siteurl_backend') . '/rfq/index?RfqFilter%5Bid%5D=' . $id,
                    'status' => 0,
                    'created_at' => time()
                ]);
                return $id;
            }
        }
    }

}

?>