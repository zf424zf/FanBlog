<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/22 0022
 * Time: 下午 9:09
 */

namespace App\Handlers;


use App\Models\User;
use Carbon\Carbon;

trait UserHandle
{
    public $cacheRegKey = 'fanbbs_user_reg_';
    public $expire = 120;

    public function generateToken(User $user)
    {
        $time = Carbon::now()->toDateTimeString();
        $token = md5($user->id . $time . str_random(16));
        return $token;
    }

    public function getRegToken(User $user)
    {
        $token = $this->generateToken($user);
        return \Cache::remember($this->cacheRegKey . $token, 120, function () use ($user, $token) {
            return ['uid' => $user->id, 'token' => $token];
        });
    }
}