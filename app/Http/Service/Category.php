<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/16 0016
 * Time: 上午 11:09
 */

namespace App\Http\Service;

use App\Models\Category as CategoryModel;
use App\Http\Service\RedisHandle as RedisHandle;
use Carbon\Carbon;

class Category
{

    /**
     * 获取category
     * @return array|mixed
     */
    public static function getCategories()
    {
        $categories = RedisHandle::get('categories');
        if (empty($categories)) {
            $categories = (new self())->queryCategoriesByDB();
            self::pushCategoriesToCache($categories);
        }
        return $categories;
    }

    /**
     * 从数据库查询Categories
     * @return array
     */
    private function queryCategoriesByDB()
    {
        return $categories = CategoryModel::all()->toArray();
    }

    /**
     * 将查询的数据放入缓存
     * @param $categories
     */
    private static function pushCategoriesToCache($categories)
    {
        RedisHandle::set('categories', $categories, Carbon::now()->addDay(1));
    }
}