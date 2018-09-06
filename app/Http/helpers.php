<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function likeType()
{
    return [
        'topic' => 1,
        'moment' => 2
    ];
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}

function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix = '')
{
    // 获取数据模型的复数蛇形命名
    $model_name = model_plural_name($model);

    // 初始化前缀
    $prefix = $prefix ? "/$prefix/" : '/';

    // 使用站点 URL 拼接全量 URL
    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

    // 拼接 HTML A 标签，并返回
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    // 从实体中获取完整类名，例如：App\Models\User
    $full_class_name = get_class($model);

    // 获取基础类名，例如：传参 `App\Models\User` 会得到 `User`
    $class_name = class_basename($full_class_name);

    // 蛇形命名，例如：传参 `User`  会得到 `user`, `FooBar` 会得到 `foo_bar`
    $snake_case_name = snake_case($class_name);

    // 获取子串的复数形式，例如：传参 `user` 会得到 `users`
    return str_plural($snake_case_name);
}

/**
 * 无限级菜单排序
 * @param array $menus
 * @param null $pid
 * @return array|\Illuminate\Support\Collection
 */
function menuFormat(array $menus, $pid = null)
{
    //将菜单根据父节点倒序排，这样最底层子节点会在前面
    $menus = collect($menus)->sortByDesc('parent_id');
    //处理第一次，获得第一个子节点的父节点id
    if ($pid === null) {
        $pid = $menus->first()['parent_id'];
    }
    //查询父节点
    $father = $menus->where('id', $pid)->first();
    //父节点不为空，进行处理
    if (!empty($father)) {
        //查询所有父节点为pid的子节点
        $son = array_values($menus->where('parent_id', $pid)->toArray());
        //如果没有子节点则return
        if(empty($son)){
           return $menus;
        }
        //父节点增加所有子元素
        $father['son'] = $son;
        //筛选除了该父节点和子节点的其他元素
        $other = $menus->where('id', '!=', $pid)->where('parent_id', '!=', $pid);
        //合并成新的数组并赋值给menus
        $menus = collect(array_merge($other->toArray(), [$father]))->sortByDesc('parent_id');
    }
    foreach ($menus as $menu) {
        //因为menus的书序为parent_id倒序，所以如果父节点为0，表示菜单以及排序完毕
        if($menu['parent_id'] == 0){
            //跳出循环
            break;
        }
        if (!is_array($menus)) {
            $menus = $menus->toArray();
        }
        //否则递归调用
        $menus = menuFormat($menus, $menu['parent_id']);
    }
    return $menus;
}