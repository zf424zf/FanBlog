<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/6 0006
 * Time: 下午 9:09
 */

namespace App\Models;


class Menu extends Model
{
    protected $table = 'menu';

    protected static $cacheKey = 'fanbbs_menus';

    public static function getMenus()
    {
        if ($menus = \Cache::get(self::$cacheKey)) {
            return $menus;
        }
        $menus = Menu::all()->toArray();
        $menuFormat = menuFormat($menus);
        \Cache::set(self::$cacheKey, $menuFormat, now()->addDays(30));
        return $menuFormat;
    }
}