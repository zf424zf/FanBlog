<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/22 0022
 * Time: 下午 9:55
 */

namespace App\Models\Traits;


trait UserStatus
{
    public $noValidUser = 0;//未验证用户
    public $passUser = 1;//正常用户
    public $blackUser = 2;//被封号
}