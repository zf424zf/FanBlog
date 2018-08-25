<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;

class VerificationCodesController extends Controller
{
    //
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {
        $captchaData = \Cache::get($request->captcha_key);

        if(!$captchaData){
            return $this->response->error('图片验证码失效',422);
        }

        if(!hash_equals($captchaData['code'], $request->captcha_code)){
            // 验证错误就清除缓存再生成验证码
            \Cache::forget($request->captcha_key);
            return $this->response->errorUnauthorized('验证码错误');
        }

        $phone = $captchaData['phone'];//获取电话

        if (!app()->environment('production')) {
            $code = '5666';
        } else {
            //生成四位随机数
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
            try {
                $result = $easySms->send($phone, ['content' => "【FanBBS博客】您的验证码是{$code}。如非本人操作，请忽略本短信"]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $response = $exception->getResponse();
                $result = json_decode($response->getBody()->getContents(), true);
                return $this->response->errorInternal($result['msg'] ?? '短信发送异常');
            }
        }
        //生成缓存key,设置缓存期限，存入缓存
        $key = 'verification_' . str_random(15);
        $expire = now()->addMinutes(10);
        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expire);

        // 清除图片验证码缓存
        \Cache::forget($request->captcha_key);


        return $this->response->array(['key' => $key, 'expire' => $expire->toDateTimeString()])->setStatusCode(201);
    }
}
