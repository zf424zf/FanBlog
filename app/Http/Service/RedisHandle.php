<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/16 0016
 * Time: 上午 11:18
 */

namespace App\Http\Service;


class RedisHandle
{
    public static function get($key)
    {
        return \Cache::get($key);
    }

    public static function set($key, $value, $expire)
    {
        try {
            \Cache::set($key, $value, $expire);
        } catch (\Psr\SimpleCache\InvalidArgumentException $exception) {
            return false;
        }
        return true;
    }
}