<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Models\User;

class UsersController extends Controller
{
    //
    public function store(UserRequest $request)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            return $this->response->error('验证码已失效', 422);
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            //现在用户需要用正确的验证码来创建用户，验证码可以作为用户的身份凭证，401 是合适的状态码。
            return $this->response->errorUnauthorized('验证码错误');
        }
        //创建用户
        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
        ]);
        //清除缓存
        \Cache::forget($request->verification_key);
        return $this->response->created();
    }
}
