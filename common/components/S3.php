<?php

/**
 * S3 Upload component for Yii2 framework
 *
 * S3 is a wrapper for AWS SDK for PHP (@link https://github.com/aws/aws-sdk-php)
 * This wrapper contains minimal functionality as there is only so much I want to allow access to from the Yii public end
 *
 * @version 0.1
 *
 * @author Maxim Gordienko (3dmaxpayne.com)
 */

namespace common\components;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use yii\base\Component;
use yii\base\Exception;

class S3 extends Component {

    private $_s3;
    public $key;    // AWS Access key
    public $secret; // AWS Secret key
    public $bucket;
    public $lastError = "";

    /**
     * Return S3 Client instance
     * @return S3Client
     */
    private function getInstance() {
        if ($this->_s3 === NULL)
            $this->connect();
        return $this->_s3;
    }

    /**
     * Instance the S3 object
     */
    public function connect() {
        if ($this->key === NULL || $this->secret === NULL)
            throw new Exception('S3 Keys are not set.');
        $this->_s3 = S3Client::factory([
                    'key' => $this->key,
                    'secret' => $this->secret,
        ]);
    }

    /**
     * Upload file to S3
     * @param string $file path to file on local server
     * @param string $fileName name of file on Amazon. It can include directories.
     * @param null $bucket bucket name. By default use bucket from config
     */
    public function upload($file, $fileName, $bucket = null) {
        if (!$bucket) {
            $bucket = $this->bucket;
        }
        $s3 = $this->getInstance();
        try {
            $result =$s3->putObject(array(
                'Bucket' => $bucket,
                'Key' => $fileName,
                'Body' => fopen($file, 'r'),
                'ACL' => 'public-read',
            ));
            return $result['ObjectURL'];
        } catch (S3Exception $e) {
            echo "There was an error uploading the file.\n";
        }
    }

    /**
     * Use for call another functions of S3Client
     * @param string $func
     * @param array $args
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function __call($func, $args) {
        $s3 = $this->getInstance();
        return call_user_func([$s3, $func], $args[0]);
    }

}
