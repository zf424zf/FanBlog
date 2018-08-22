<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/22 0022
 * Time: 上午 10:16
 */

namespace App\Observers;


use App\Models\Link;

class LinkObserver
{
    public function saved(Link $link)
    {
        \Cache::forget($link->cacheKey);
    }
}