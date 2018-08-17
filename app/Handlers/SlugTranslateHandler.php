<?php
/**
 * Created by PhpStorm.
 * User: zf424zf
 * Date: 2018/8/17
 * Time: 21:33
 */

namespace App\Handlers;


use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler
{

    /**
     * 翻译处理函数
     * @param $text
     * @return string
     */
    public function translate($text)
    {
        //初始化guzzle http客户端
        $http = new Client();

        //init 配置信息
        $api = "http://api.fanyi.baidu.com/api/trans/vip/translate?";
        $appid= config('services.baidu_translate.appid');
        $key = config('services.baidu_translate.key');
        $salt = time();
        //如果没有接入百度翻译，使用pinyin包进行翻译
        if(empty($key) || empty($appid)){
            return $this->pinyin($text);
        }
        //生成百度翻译的签名
        $sign = md5($appid. $text . $salt . $key);

        //构建请求参数
        $query = http_build_query([
            "q"     =>  $text,//请求翻译query
            "from"  => "zh",//翻译源语言
            "to"    => "en",//译文语言
            "appid" => $appid,
            "salt"  => $salt,//随机数
            "sign"  => $sign,//签名
        ]);
        //发送http get请求
        $response = $http->get($api . $query);
        //将返回结果转化为数组
        $result = json_decode($response->getBody(),true);
        \Log::error(json_encode($result));
        //获取翻译结果 没有结果则使用拼音组件
        if(isset($result['trans_result'][0]['dst'])){
            return str_slug($result['trans_result'][0]['dst']);
        }else{
            return $this->pinyin($text);
        }
    }

    /**
     * 调用拼音组件处理翻译
     * @param $text
     * @return string
     */
    private function pinyin($text){
        return str_slug(app(Pinyin::class)->permalink($text));
    }
}