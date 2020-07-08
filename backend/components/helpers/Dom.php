<?php

namespace backend\components\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\Post;
use common\models\Category;
use common\models\CategoryPost;
use backend\components\Convert;
set_time_limit(0);
class Dom {

    public $domain = "http://www.apk-mania.co";
    public $database_link = array();

    function __construct() {
        $this->getAllUrlInDatabase();
    }

    // @getMutipeIds
    function cRonData() {

        $links = $this->getALLinks();

        //loop all links
        foreach ($links as $link) {
            if (!in_array($link, $this->database_link)) {
                //get details
                $this->getDetails($link);
            }
        }
    }

    //a viết 2 hàm này nhé
    function getAllUrlInDatabase() {

        $urls = array();
        //query_get_all_link from dataabse
        $post = Post::find()->all();
        if (!empty($post)) {
            foreach ($post as $value) {
                $urls[] = $value->url;
            }
        }
        $this->database_link = $urls;
    }

    //a viết 2 hàm này nhé
    function insertDatabase($data) {
        $model = new Post();
        $model->title = $data['name'];
        $model->slug = Yii::$app->convert->string($data['name']);
        $model->category_id = 0;
        $model->main_image = $data['main_image'];
        $model->thumb_image = $data['thumb_image'];
        $model->cats = $data['cats'];
        $model->content = $data['descriptions'];
        $model->size = $data['size'];
        $model->url_download = $data['url_download'];
        $model->googleplay_url = $data['googleplay_url'];
        $model->status = $data['post_status'];
        $model->slide_img = $data['slide_img'];
        $model->type = 'post';
        $model->url = $data['url'];
        $model->user_id = Yii::$app->user->id;
        if ($model->save()) {
            $array = explode('|', str_replace(' ', '', $model->cats));
            $categories = Category::find()->where(['IN', 'title', $array])->all();
            if (!empty($array)) {
                foreach ($categories as $cat) {
                    $exit = CategoryPost::find()->where(['category_id' => $cat->id, 'post_id' => $model->id])->one();
                    if (empty($exit)) {
                        $postcat = new CategoryPost();
                        $postcat->category_id = $cat->id;
                        $postcat->post_id = $model->id;
                        $postcat->save();
                    }
                }
            }
        }
    }

    function getALLinks() {

        $links = array();
        for ($i = 1; $i <= 20; $i++) {
            $html = $this->get_fcontent("http://www.apk-mania.com/sitemap.xml?page=" . $i);
            $html_base = new simple_html_dom();
            $html_base->load($html);
            $nodes = $html_base->find("loc");
            foreach ($nodes as $node) {
                if (trim($node->plaintext) != '') {
                    $links[] = trim($node->plaintext);
                }
            }

            //clear html_base
            $html_base->clear();
            unset($html_base);
        }

        return array_unique($links);
    }

    function getDetails($link) {

        $html = $this->get_fcontent($link);
        $html_base = new simple_html_dom();
        $html_base->load($html);
//        $html_base = SimpleHTMLDom::file_get_html($link);
        $title = $html_base->find("h1.post-title");
        if (isset($title[0])) {

            $ar_link = $title[0]->find("a");
            $link = (isset($ar_link[0])) ? trim($ar_link[0]->href) : '';

            $data = array(
                'name' => '', 'main_image' => '', 'thumb_image' => '', 'postdate' => '', 'cats' => '',
                'descriptions' => '', 'size' => '', 'url_download' => '', 'googleplay_url' => '', 'post_status' => 'publish', 'slide_img' => '', 'url' => $link);

            //name
            $data['name'] = trim($title[0]->plaintext);

            //main_image
            $main_image = $html_base->find('.separator img[width="728"]');
            $data['main_image'] = (isset($main_image[0])) ? trim($main_image[0]->src) : '';

            //thumb_image
            $thumb_images = $html_base->find('.post-body img');
            foreach ($thumb_images as $thumb_image) {
                if (strrpos($thumb_image->src, '=w300') !== false) {
                    $data['thumb_image'] = trim($thumb_image->src);
                    break;
                }
            }

            //postdate
            $postdate = $html_base->find("#IDCommentInfoPostTime");
            $data['postdate'] = (isset($postdate[0])) ? trim($postdate[0]->plaintext) : '';
            if (strlen($data['postdate']) > 10) {
                $data['postdate'] = substr($data['postdate'], 0, 10);
            }
            //cats
            $cats = $html_base->find('.post-labels a');
            $tmp_cat = array();
            foreach ($cats as $cat) {
                if (strrpos($cat->rel, 'tag') !== false) {
                    $tmp_cat[] = trim($cat->plaintext);
                }
            }
            $data['cats'] = implode(' | ', $tmp_cat);

            //download
            $file_sizes = $html_base->find("span.Apple-style-span");
            foreach ($file_sizes as $file_size) {
                if (trim($file_size->plaintext) == 'Download' && isset($file_size->next_sibling()->tag) && isset($file_size->next_sibling()->next_sibling()->tag)) {

                    $data['size'] = trim($file_size->next_sibling()->next_sibling()->plaintext);
                    break;
                }
            }

            $imgs = $html_base->find("img");
            $url_download = array();
            foreach ($imgs as $img) {
                if (trim($img->src) == 'http://i.imgur.com/gu2JV.png') {
                    if ($img->parent()->tag == 'a') {
                        $url_download[] = trim($img->parent()->href);
                        if (isset($img->parent()->next_sibling()->tag) && $img->parent()->next_sibling()->tag == 'a'
                        ) {
                            $url_download[] = trim($img->parent()->next_sibling()->href);
                        }
                    } elseif ($img->parent()->parent()->tag == 'a') {
                        $url_download[] = trim($img->parent()->parent()->href);
                        if (isset($img->parent()->parent()->next_sibling()->tag) && $img->parent()->parent()->next_sibling()->tag == 'a'
                        ) {
                            $url_download[] = trim($img->parent()->parent()->next_sibling()->href);
                        }
                    }
                }
            }
            $data['url_download'] = implode("\n", $url_download);

            $googleplay_urls = $html_base->find("a");
            foreach ($googleplay_urls as $googleplay_url) {
                if (strrpos($googleplay_url->href, 'play.google.com/store/apps/details?id=') !== false) {
                    $data['googleplay_url'] = trim($googleplay_url->href);
                    break;
                }
            }

            //remove table tag
            foreach ($html_base->find('img[width="160"]') as $item) {
                $item->outertext = '';
            }
            //slide_img
            $slide_img = array();
            $thumbs = $html_base->find(".post-body img");
            foreach ($thumbs as $thumb) {
                if (trim($thumb->src) != $data['main_image'] && trim($thumb->src) != $data['thumb_image'] && trim($thumb->src) != 'http://i.imgur.com/gu2JV.png'
                ) {
                    $slide_img[] = trim($thumb->src);
                }
            }
            $data['slide_img'] = implode("\n", $slide_img);


            foreach ($html_base->find('.post-body img') as $item) {
                $item->outertext = '';
            }
            foreach ($html_base->find('.post-body b') as $item) {
                if (strrpos($item->plaintext, 'Screenshots :') !== false) {
                    $item->parent()->parent()->outertext = '';
                }
            }
            $html_base->save();

            $post_bodys = $html_base->find(".post-body");
            foreach ($post_bodys as $post_body) {
                if (strrpos($post_body->id, 'post-body') !== false) {

                    $data['descriptions'] = trim($post_body->first_child()->first_child()->innertext);
                    $data['descriptions'] = str_replace('&nbsp;', ' ', $data['descriptions']);
                    $repl_ar = array('<div style="text-align: center;"> </div>', 'Screenshots :', ' class="separator"', '<!-- Adsense -->', ' trbidi="on"', '<div> </div>', '<div style=\'float:left;margin:10px 0\'> </div>', ' style="font-family: Verdana, sans-serif;"', ' dir="ltr"', '<div trbidi="on"> </div>');
                    $data['descriptions'] = str_replace($repl_ar, '', $data['descriptions']);
                    $data['descriptions'] = preg_replace('/(<br[^>]*>\s*){2,}/', '<br />', $data['descriptions']);
                    $data['descriptions'] = str_replace(array('>  <br />', '> <br />', '><br />'), '>', $data['descriptions']);
                    $data['descriptions'] = str_replace('style="color: yellow;"', 'class="yellow"', $data['descriptions']);
                    $data['descriptions'] = str_replace('style="color: white;"', 'class="white"', $data['descriptions']);
                    $data['descriptions'] = str_replace('style="text-align: left;"', 'class="text-left"', $data['descriptions']);
                    $data['descriptions'] = str_replace('<div style="clear: both; text-align: center;"> </div>', '', $data['descriptions']);
                    $data['descriptions'] = str_replace('Apple-style-span', 'ilk-span', $data['descriptions']);
                    break;
                }
            }
            $this->insertDatabase($data);
        }

        //clear html_base
        $html_base->clear();
        unset($html_base);
    }

    //@get_fcontent
    function get_fcontent($url) {

        $ch = curl_init();
        $headers = array();
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $headers[] = 'Accept-Language: en-US,en;q=0.5';
        $headers[] = 'Accept-Encoding: gzip, deflate';
        $headers[] = 'Connection: keep-alive';
        $cookie = realpath('cookies.txt');

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:38.0) Gecko/20100101 Firefox/38.0');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

}

?>
