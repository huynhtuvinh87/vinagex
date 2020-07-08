<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Product;
use common\models\Review;
use common\components\Constant;
use yii\mongodb\Query;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property string $fullname
 * @property string $phone
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface {

    const ROLE_SUPERADMIN = 'superadmin';
    const ROLE_ADMIN = 'admin';
    const ROLE_MEMBER = 'member';
    const ROLE_SELLER = 'seller';
    const ROLE_TRANSPORT = 'transport';
    const STATUS_ACTIVE = 2;
    const STATUS_NOACTIVE = 3;
    const PUBLIC_ACTIVE = 1;
    const PUBLIC_PENDING = 0;
    const PUBLIC_NOACTIVE = 2;

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_AFTER_UPDATE => ['updated_at']
                ]
            ]
        ];
    }

    public function attributes() {
        return [
            '_id',
            'username',
            'keyword',
            'password_hash',
            'password_reset_token',
            'email',
            'auth_key',
            'auth_hash',
            'fullname',
            'phone',
            'avatar',
            'role',
            'status',
            'public',
            'address',
            'garden_name',
            'category',
            'acreage',
            'acreage_unit',
            'lat',
            'long',
            'active',
            'username',
            'email',
            'phone',
            'about',
            'images',
            'certificate',
            'trademark',
            'output_provided',
            'output_provided_unit',
            'insurance_money',
            'facebook',
            'image_verification',
            'level',
            'province',
            'district',
            'ward',
            'error',
            'display',
            'reason',
            'transport_code',
            'payment',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['status', 'default', 'value' => self::STATUS_NOACTIVE],
            ['public', 'default', 'value' => self::PUBLIC_NOACTIVE],
            [['active', 'insurance_money', 'reason'], 'default'],
        ];
    }

    public function attributeLabels() {
        return array(
            'fullname' => 'Họ tên',
            'garden_name' => 'Tên nhà vườn',
            'phone' => 'Điện thoại',
            'email' => 'Email',
            'address' => 'Địa chỉ',
            'certificate' => 'Chứng nhận',
            'category' => 'Danh mục sản phẩm',
            'trademark' => 'Thương hiệu',
            'output_provided' => 'Số lượng cung cấp',
            'acreage' => 'Quy mô nhà vườn',
            'about' => 'Giới thiệu',
            'images' => 'Hình ảnh'
        );
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
//        $timestamp = (int) substr($token, strrpos($token, '_') + 1);

        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return (string) $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public function getCountProduct() {
        return Product::find()->where(['owner.id' => $this->id])->count();
    }

    public function getProduct() {
        return Product::find()->where(['owner.id' => $this->id, 'status' => Constant::STATUS_ACTIVE])->orderBy(['created_at'])->limit(4)->all();
    }

    public function getCountPaymentHistory() {
        return PaymentHistory::find()->where(['owner' => $this->id])->count();
    }

    public function getUrl() {
        return Yii::$app->urlManager->createAbsoluteUrl([!empty($this->username) ? '/nha-cung-cap/' . $this->username . '-' . $this->id : '/nha-vuon/' . $this->id]);
    }

    public function getCountReview() {
        return Review::find()->where(['owner.id' => $this->id, 'status' => Constant::STATUS_ACTIVE])->count();
    }

    public function countstar($star) {
        return Review::find()->where(['owner.id' => $this->id, 'star' => $star, 'status' => Constant::STATUS_ACTIVE])->count();
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

    public function percentageDeal() {

        $order_final = (new Query)->from('order')->where(['owner.id' => $this->id])->orderBy(['_id' => SORT_DESC])->one();

        if ($order_final) {
            $order_seven_days_ago = $order_final['created_at'] - 604800;

            $total_order_success = (new Query)->from('order')->where(['owner.id' => $this->id])->andWhere(['>=', 'created_at', $order_seven_days_ago])->andWhere(['NOT IN', 'status', [Constant::STATUS_ORDER_PENDING, Constant::STATUS_ORDER_BLOCK]])->count();

            $total = (new Query)->from('order')->where(['owner.id' => $this->id])->andWhere(['>=', 'created_at', $order_seven_days_ago])->count();

            if ($total > 0) {
                $percentage_complete = ($total_order_success / $total) * 100;
            } else {
                $percentage_complete = 0;
            }
            return number_format((float) $percentage_complete, 0, '.', '');
        } else {
            return 0;
        }
    }

    public function countDeal() {
        return (new Query)->from('order')->where(['owner.id' => $this->id, 'status' => Constant::STATUS_ORDER_FINISH])->count();
    }

    public function countDealBuyer() {
        return (new Query)->from('order')->where(['buyer.id' => $this->id, 'status' => Constant::STATUS_ORDER_FINISH])->count();
    }

    public function count_seller_order_success() {
        $order = (new Query)->from('order')->where(['buyer.id' => $this->id, 'status' => Constant::STATUS_ORDER_FINISH])->all();
        $owner = [];
        foreach ($order as $value) {
            $owner[] = $value['owner']['id'];
        }
        return count(array_unique($owner));
    }

    public function count_review_buyer($id) {
        return (new Query)->from('review_buyer')->where(['buyer.id' => $this->id, 'level_satisfaction' => (int) $id])->count();
    }

    public function getLike() {
        $query = (new Query)->from('wishlist')->where(['user_id' => \Yii::$app->user->id, 'seller_id' => $this->id])->one();
        if ($query) {
            return TRUE;
        }
        return FALSE;
    }

}
