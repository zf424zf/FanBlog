<?php
/**
 * Created by PhpStorm.
 * User: zf424zf
 * Date: 2018/11/24
 * Time: 23:27
 */

namespace App\Http\Controllers;



use Illuminate\Http\Request;

class WXController extends Controller
{
    private $appId;
    private $secret;

    public function __construct()
    {
        $this->appId = env('WX_APPID');
        $this->secret = env('WX_SECRET');
    }

    public function config(Request $request)
    {
        $url = $request->url;
        return $this->signAndBack($url);
    }

    private function getAccessToken()
    {
        return $accessToken = \Cache::remember('fanbbs_access_token', 120, function () {
            //获取access_token的请求地址
            $accessTokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->secret";
            //请求地址获取access_token
            $accessTokenJson = file_get_contents($accessTokenUrl);
            $accessTokenObj = json_decode($accessTokenJson);
//            dd($accessTokenObj);
            $accessToken = $accessTokenObj->access_token;
            return $accessToken;
        });
    }

    private function getTicket()
    {
        $accessToken = $this->getAccessToken();
        //获取jsapi_ticket的请求地址
        $ticketUrl = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$accessToken&type=jsapi";
        $jsapiTicketJson = file_get_contents($ticketUrl);
        $jsapiTicketObj = json_decode($jsapiTicketJson);
        return $jsapiTicketObj->ticket;
    }

    private function signAndBack($url){
        $ticket = $this->getTicket();
        //随机生成16位字符
        $noncestr = str_random(16);
        //时间戳
        $time = time();
        //拼接string1
        $ticketNew = "jsapi_ticket=$ticket&noncestr=$noncestr&timestamp=$time&url=$url";
        //对string1作sha1加密
        $signature = sha1($ticketNew);
        //存入数据
        return $data = [
            'appid' => $this->appId,
            'timestamp' => $time,
            'nonceStr' => $noncestr,
            'signature' => $signature,
            'jsapiTicket' => $ticket,
            'url' => $url,
            'jsApiList' => [
                'api' => '#'
            ]
        ];
    }
}