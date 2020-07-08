<?php 
namespace seller\models;

use Yii;
use yii\base\Model;
use yii\mongodb\Query;

class PaymentForm extends Model {
    public $id;
    public $bank_id;
    public $name_bank;
    public $account_name;
    public $account_number;
    public $branch_bank;
    public $owner_id;

    public function init() {
        parent::init();
        if(!empty($this->bank_id)){
            $model = (new Query)->from('payment')->where(['bank.id'=>$this->bank_id])->one();
            $key = array_search($this->bank_id, array_column($model['bank'], 'id'));
            $bank = $model['bank'][$key];
            $this->id = (string)$model['_id'];
            $this->owner_id = $model['owner']['id'];
            $this->name_bank = $bank['name_bank'];
            $this->account_name = $bank['account_name'];
            $this->account_number = $bank['account_number'];
            $this->branch_bank = $bank['branch_bank'];

        }
    }

    public function rules(){
    	return [
            [['name_bank','account_name','account_number','branch_bank'],'required','message' => '{attribute} không được bỏ trống'],
            [['account_number'],'number','message'=> '{attribute} chỉ đưọc nhập số'],
    	];
    }

    public function attributeLabels(){
        return [
            'name_bank' => 'Tên ngân hàng',
            'account_name' => 'Tên tài khoản ngân hàng',
            'account_number' => 'Số tài khoản ngân hàng',
            'branch_bank' => 'Chi nhánh',
        ];
    }

    public function save(){
        if($this->validate()){
                if(empty($this->bank_id)){
                    $payment = (new Query)->from('payment')->where(['owner.id'=>Yii::$app->user->id])->one();
                    $data_bank = [
                            'id' => (string) new  \MongoDB\BSON\ObjectID(),
                            'name_bank' => $this->name_bank,
                            'account_name' => $this->account_name,
                            'account_number' => $this->account_number,
                            'branch_bank' => $this->branch_bank,
                        ];

                    if(empty($payment)){
                        $owner = [
                            'id' => Yii::$app->user->id,
                            'fullname' => Yii::$app->user->identity->fullname,
                            'username' => Yii::$app->user->identity->username,
                            'garden_name' => Yii::$app->user->identity->garden_name,
                            'province' => Yii::$app->user->identity->province,
                            'district' => Yii::$app->user->identity->district,
                            'ward' => Yii::$app->user->identity->ward,
                            'address' => Yii::$app->user->identity->address
                        ];
                        $bank[] = $data_bank;
                        $data = [
                            'bank' => $bank,
                            'owner' => $owner
                        ];

                        return Yii::$app->mongodb->getCollection('payment')->insert($data);
                    }else{
                        return Yii::$app->mongodb->getCollection('payment')->update(['_id'=>(string)$payment['_id']],['$push'=>['bank'=>$data_bank]]);
                    }
                }else{
                        return Yii::$app->mongodb->getCollection('payment')->update(['_id'=>$this->id,'bank.id'=>$this->bank_id],['$set'=>[
                            'bank.$.name_bank' => $this->name_bank,
                            'bank.$.account_name' => $this->account_name,
                            'bank.$.account_number' => $this->account_number,
                            'bank.$.branch_bank' => $this->branch_bank,
                        ]]);
                }
        }
    }
}

 ?>