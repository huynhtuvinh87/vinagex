<?php

/**
 * Created by PhpStorm.
 * User: huynhtuvinh87
 * Date: 5/24/17
 * Time: 17:08
 */

namespace common\components;

use Yii;
use yii\mongodb\Query;


class Constant {
    function _construct() {
        
    }
    
    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_NOACTIVE = 3;
    const STATUS_BLOCK = 4;
    const STATUS_CANCEL = 5;
    const STATUS_FINISH = 6;
    const STATUS_DENY = 7;
    const STATUS_STOP = 8;
    const TYPE_RADIO = 1;
    const TYPE_CHECKBOX = 2;
    const STATUS_ORDER_PENDING = 1;
    const STATUS_ORDER_SENDING = 2;
    const STATUS_ORDER_FINISH = 5;
    const STATUS_ORDER_BLOCK = 4;
    const STATUS_ORDER_UNSUCCESSFUL = 6;
    const NO_IMAGE = '/images/no_image.png';
    const UP_IMAGE = '/images/up_image.png';
    const ROLE_SUPERADMIN = 'superadmin';
    const ROLE_ADMIN = 'admin';
    const ROLE_SELLER = 'seller';
    const ROLE_MEMBER = 'member';
    const LEVEL_YELLOW = 1;
    const LEVER_SILVER = 2;
    const LEVER_COPPER = 3;
    const PROVINCE_TQ = 1;
    const SALE_DEAL = 1;
    const SALE_FRAME = 2;
    const PRODUCT_SALE = [
        1 => 'Bán theo deal',
        2 => 'Bán sỉ',
        3 => 'Bán lẻ',
    ];
    const PRODUCT_STATUS = [
        2 => 'Hiển thị',
        3 => 'Không hiển thị',
    ];
    const USER_LEVEL = [
        3 => 'Nhà cung cấp vàng',
        2 => 'Nhà cung cấp bạc',
        1 => 'Nhà cung cấp đồng',
        0 => 'Chưa có danh hiệu'
    ];
    const REVIEW_BUYER = [
        1 => 'Hài lòng',
        2 => 'Bình thường',
        3 => 'Không hài lòng'
    ];
    const GENDER = [
        1 => 'Nam',
        2 => 'Nữ',
    ];
    const STATUS_ORDER = [
        1 => 'Đang chờ xử lý',
        2 => 'Đang giao hàng',
        3 => 'Giao hàng thành công',
        4 => 'Huỷ đơn hàng'
    ];
    const PRICE_BY_AREA = [
        1 => 'Toàn quốc',
        2 => 'Tỉnh thành',
    ];
    const UNIT_OF_CALCULATION = [
        'kg' => 'Kilogam',
        'trái' => 'Trái',
        'bo' => 'Bó',
        'chau' => 'Chậu'
    ];
    const STATUS_SHOW_APPLY = [
        self::STATUS_PENDING => '<span class="badge badge-primary badge-pill item-status">Đang chờ xử lý</span>',
        self::STATUS_ACTIVE => '<span class="badge badge-success badge-pill item-status">Đã đồng ý</span>',
        self::STATUS_DENY => '<span class="badge badge-danger badge-pill item-statusr">Từ chối</span>',
        self::STATUS_CANCEL => '<span class="badge badge-danger badge-pill item-statusr">Đã hủy</span>',
        self::STATUS_STOP => '<span class="badge badge-danger badge-pill item-statusr">Đã dừng tìm hàng</span>'
    ];
    const STATUS_SHOW_RFQ = [
        self::STATUS_PENDING => '<span class="badge badge-primary badge-pill item-status">Đang tìm hàng</span>',
        self::STATUS_FINISH => '<span class="badge badge-success badge-pill item-status">Đã có hàng</span>',
        self::STATUS_NOACTIVE => '<span class="badge badge-danger badge-pill item-status">Đang chờ duyệt</span>',
        self::STATUS_CANCEL => '<span class="badge badge-danger badge-pill item-statusr">Đã hủy yêu cầu</span>',
        self::STATUS_STOP => '<span class="badge badge-danger badge-pill item-statusr">Đã dừng tìm hàng</span>'
    ];
    const USER_LABEL = [
        'fullname' => 'Tên chủ liên hệ',
        'garden_name' => 'Tên cơ sở',
        'email' => 'Email',
        'password' => 'Mật khẩu',
        'phone' => 'Điện thoại',
        'about' => 'Gới thiệu',
        'birthday' => 'Ngày sinh',
        'province_id' => 'Tỉnh/thành',
        'gender' => 'Giới tính',
        'avatar' => 'Hình đại diện',
        'images' => 'Hình ảnh nhà vườn',
        'address' => 'Địa chỉ',
        'certificate' => 'Chứng nhận',
        'certificate_document' => 'Hình ảnh chứng nhân',
        'password_new' => 'Mật khẩu mới',
        'password_rep' => 'Xác nhận mật khẩu mới',
        'username' => 'Tên đăng nhập',
        'trademark' => 'Thương hiệu',
        'product_provided' => 'Sản phẩm cung cấp',
        'output_provided' => 'Sản lượng cung cấp',
        'acreage' => 'Quy mô / Diện tích'
    ];
    const ORDER_LABEL = [
        'name' => 'Họ và tên',
        'phone' => 'Điện thoại',
        'address' => 'Địa chỉ giao hàng',
        'province_id' => 'Tỉnh / thành',
        'note' => 'Ghi chú',
        'code' => 'Mã đơn hàng',
        'total' => 'Tổng tiền',
        'status' => 'Trạng thái',
        'created_at' => 'Ngày mua'
    ];
    const LANGUAGE = [
        'vi' => 'Tiếng Việt',
        'en' => 'English',
        'cn' => 'China',
        'kr' => 'Korea',
        'jp' => 'Janpanse'
    ];

    public static function category() {
        $query = new Query();
        $query->select(['title', '_id'])
                ->from('category');
        $rows = $query->all();
        $data = [];
        if (!empty($rows)) {
            foreach ($rows as $key => $value) {
                $data[(string) $value['_id']] = $value['title'];
            }
        }
        return $data;
    }

    public static function categorySlug() {
        $query = new Query();
        $query->select(['title', 'slug'])
                ->from('category');
        $rows = $query->all();
        $data = [];
        if (!empty($rows)) {
            foreach ($rows as $key => $value) {
                $data[$value['slug']] = $value['title'];
            }
        }
        return $data;
    }

    public static function category_sub() {
        $category = Yii::$app->db->createCommand('SELECT title,id FROM category where parent_id <> 0')->queryAll();
        $data = [];
        if (!empty($category)) {
            foreach ($category as $key => $value) {
                $data[$value['id']] = $value['title'];
            }
        }
        return $data;
    }

    public static function category_parent($id) {
        $query = new Query();
        $query->select(['title', '_id'])
                ->from('category')
                ->where(['parent_id' => $id]);
        $rows = $query->all();
        $data = [];
        if (!empty($rows)) {
            foreach ($rows as $key => $value) {
                $data[(string) $value['_id']] = $value['title'];
            }
        }
        return $data;
    }

    public static function province() {
        $query = new Query();
        $query->select(['name', '_id'])
                ->from('province');
        $rows = $query->all();
        $data = [];
        foreach ($rows as $value) {
            $data[(string) $value['_id']] = $value['name'];
        }
        return $data;
    }

    public static function excerpt($str, $length) {
        $str = strip_tags($str, '');
        if (strlen($str) < $length)
            return $str;
        else {
            $str = strip_tags($str);
            $str = substr($str, 0, $length);
            $end = strrpos($str, ' ');
            $str = substr($str, 0, $end);
            return $str;
        }
    }

    public static function slug($str) {
        $str = trim($str);
        $strFind = [
            '- ',
            ' ',
            'đ', 'Đ',
            'á', 'à', 'ạ', 'ả', 'ã', 'Á', 'À', 'Ạ', 'Ả', 'Ã', 'ă', 'ắ', 'ằ', 'ặ', 'ẳ', 'ẵ', 'Ă', 'Ắ', 'Ằ', 'Ặ', 'Ẳ', 'Ẵ', 'â', 'ấ', 'ầ', 'ậ', 'ẩ', 'ẫ', 'Â', 'Ấ', 'Ầ', 'Ậ', 'Ẩ', 'Ẫ',
            'ó', 'ò', 'ọ', 'ỏ', 'õ', 'Ó', 'Ò', 'Ọ', 'Ỏ', 'Õ', 'ô', 'ố', 'ồ', 'ộ', 'ổ', 'ỗ', 'Ô', 'Ố', 'Ồ', 'Ộ', 'Ổ', 'Ỗ', 'ơ', 'ớ', 'ờ', 'ợ', 'ở', 'ỡ', 'Ơ', 'Ớ', 'Ờ', 'Ợ', 'Ở', 'Ỡ',
            'é', 'è', 'ẹ', 'ẻ', 'ẽ', 'É', 'È', 'Ẹ', 'Ẻ', 'Ẽ', 'ê', 'ế', 'ề', 'ệ', 'ể', 'ễ', 'Ê', 'Ế', 'Ề', 'Ệ', 'Ể', 'Ễ',
            'ú', 'ù', 'ụ', 'ủ', 'ũ', 'Ú', 'Ù', 'Ụ', 'Ủ', 'Ũ', 'ư', 'ứ', 'ừ', 'ự', 'ử', 'ữ', 'Ư', 'Ứ', 'Ừ', 'Ự', 'Ử', 'Ữ',
            'í', 'ì', 'ị', 'ỉ', 'ĩ', 'Í', 'Ì', 'Ị', 'Ỉ', 'Ĩ',
            'ý', 'ỳ', 'ỵ', 'ỷ', 'ỹ', 'Ý', 'Ỳ', 'Ỵ', 'Ỷ', 'Ỹ'
        ];
        $strReplace = [
            '',
            '-',
            'd', 'd',
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i',
            'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y'
        ];
        return strtolower(preg_replace('/[^a-z0-9\-]+/i', '', str_replace($strFind, $strReplace, $str)));
    }

    public static function price($int) {
        if ($int > 0) {
            return number_format($int, 0, '', ',');
        }
    }

    public static function convertTime($time) {
        $s = strtotime(str_replace('/', '-', $time));
        return \Yii::$app->formatter->asDatetime($s, "php:Y-m-d");
    }

    public static function timeBegin($begin, $end) {
        if ($begin == $end) {

            $timestamp = strtotime(str_replace('/', '-', $end));
            $new_end = $timestamp + 2 * 24 * 60 * 60;
            return \Yii::$app->formatter->asDatetime($new_end, "php:Y-m-d");
        } else {
            return self::convertTime($end);
        }
    }

    public static function time($date) {
        $time = date('Y-m-d H:i:s', $date);
        $ago = strtotime(date('Y-m-d H:i:s', time())) - strtotime($time);
        if ($ago >= 31536000) {
            return floor($ago / 31536000) . ' ' . Yii::t('common', 'năm trước');
        } elseif ($ago >= 2592000) {
            return floor($ago / 2592000) . ' ' . Yii::t('common', 'tháng trước');
        } elseif ($ago >= 86400) {
            return floor($ago / 86400) . ' ' . Yii::t('common', 'ngày trước');
        } elseif ($ago >= 3600) {
            return floor($ago / 3600) . ' ' . Yii::t('common', 'giờ trước');
        } elseif ($ago >= 60) {
            return floor($ago / 60) . ' ' . Yii::t('common', 'phút trước');
        } else {
            return $ago . ' ' . Yii::t('common', 'giây trước');
        }
    }

    public static function unit($int) {
        if ($int < 100) {
            return $int . ' kg';
        } elseif ($int >= 100 and $int <= 999) {
            return round(($int / 100), 2) . ' tạ';
        } elseif ($int >= 1000) {
            return round(($int / 1000), 3) . ' tấn';
        }
    }

    public static function redirect($str) {
        $str = str_replace("/", "%2F", $str);
        $str = str_replace(":", "%3A", $str);
        return $str;
    }

    public static function url($str) {
        $str = str_replace("%2F", "/", $str);
        $str = str_replace("%3A", ":", $str);
        return $str;
    }

    public static function domain($url = "") {
        if (!$url) {
            return 'https://vinagex.com/';
        } else {
            return 'https://' . $url . '.vinagex.com/';
        }
    }

}
