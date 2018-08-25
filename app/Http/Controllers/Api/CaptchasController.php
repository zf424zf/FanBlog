<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\CaptchaRequest;
use Gregwar\Captcha\CaptchaBuilder;

class CaptchasController extends Controller
{
    //
    public function store(CaptchaRequest $request, CaptchaBuilder $builder)
    {
        //生成缓存key
        $key = 'captcha-' . str_random(15);
        //设置缓存时限
        $expire = now()->addMinutes(2);

        $phone = $request->phone;
        //生成图片验证码
        $captcha = $builder->build();
        \Cache::put($key, [
            'phone' => $phone,
            'code' => $captcha->getPhrase()
        ], $expire);
        //返回数据
        $result = [
            'captcha_key' => $key,
            'expire' => $expire->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()//返回base64图片验证码
        ];
        return $this->response->array($result)->setStatusCode(201);
    }
}
