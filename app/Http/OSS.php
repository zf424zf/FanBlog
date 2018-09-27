<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/27 0027
 * Time: 下午 10:20
 */

namespace App\Http;


use OSS\Core\OssException;
use OSS\OssClient;

class OSS
{
    public $accessKey = '';
    public $secret = '';
    public $endPoint = '';
    public $bucket = '';


    public function __construct()
    {
        $ossConfig = config('filesystems.disks.oss');
        $this->accessKey = $ossConfig['access_key'];
        $this->secret = $ossConfig['secret'];
        $this->endPoint = $ossConfig['end_point'];
        $this->bucket = $ossConfig['bucket'];
    }

    /**
     * @param $fileName
     * @param $content
     * @throws \OSS\Core\OssException
     */
    public function upload($fileName,$content){
        try{
            $ossClient = new OssClient($this->accessKey,$this->secret,$this->endPoint);
            \Log::error('name is ===>' . $fileName);
            $ossClient->uploadFile($this->bucket, $fileName, $content);
        }catch (OssException $exception){
            \Log::error($exception->getMessage());
        }
    }
}