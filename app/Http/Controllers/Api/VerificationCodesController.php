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
        $phone = $request->phone;//获取电话
        if (!app()->environment('production')) {
            $code = '5666';
        } else {
            //生成四位随机数
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
            try {
                $result = $easySms->send($phone, ['content' => "【FanBBS博客】您的验证码是{$code}。如非本人操作，请忽略本短信"]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $message = $exception->getException('yunpian')->getMessage();
                return $this->response->errorInternal($message ?? '短信发送失败');
            }
        }
        //生成缓存key,设置缓存期限，存入缓存
        $key = 'verification_' . str_random(15);
        $expire = now()->addMinutes(10);
        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expire);

        return $this->response->array(['key' => $key, 'expire' => $expire->toDateTimeString()])->setStatusCode(201);
    }
}
