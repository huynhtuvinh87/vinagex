<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\components\Constant;
use yii\mongodb\Query;
use common\models\TranslationProduct;

/**
 * 
 */
class CertificationForm extends Model {

    public $id;
    public $name;
    public $slug;

    public function init() {
        if (!empty($this->id)) {
            $certification = (new Query)->from('certification')->where(['_id' => (string) $this->id])->one();
            $this->name = $certification['name'];
        }
    }

    public function rules() {
        return [
            [['name'], 'required', 'message' => '{attribute} Không được bỏ trống']
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Tên chứng nhận',
        ];
    }

    public function save() {

        $collection = Yii::$app->mongodb->getCollection('certification');
        $data = [
            'name' => $this->name,
            'slug' => Constant::slug($this->name),
        ];
        if (!empty($this->id)) {
            $collection->update(['_id' => $this->id], $data);
            $id = $this->id;
        } else {
            $id = $collection->insert($data);
        }
        $transtion = new TranslationProduct();
        $transtion->add('data', [
            'message' => 'certification_' . $this->id, 'translation' => $data['name']
        ]);
        return true;
    }

}

?>