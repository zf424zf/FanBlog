<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

//注册Dingo\Api\Routing\Router路由，指定版本号V1
$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
//    'middleware' => 'serializer:array'
], function ($api) {
//路由采用throttle中间件裁流，防止恶意调用 1分钟100次调用
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires')
    ], function ($api) {
        // 短信验证码
        $api->post('verificationCodes', 'VerificationCodesController@store')
            ->name('api.verificationCodes.store');
        // 用户注册
        $api->post('users', 'UsersController@store')
            ->name('api.users.store');
        //图片验证码
        $api->post('captchas', 'CaptchasController@store')
            ->name('api.captchas.store');
        //第三方登陆
        $api->post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
            ->name('api.socials.authorizations.store');
        //登陆
        $api->post('authorizations', 'AuthorizationsController@store')
            ->name('api.authorizations.store');
        //刷新token
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorizations.update');
        //删除token
        $api->delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('api.authorizations.destroy');

        //需要token验证
        $api->group(['middleware' => 'api.auth'], function ($api) {
            //获取用户个人信息
            $api->get('user', 'UsersController@me')->name('api.user.show');
            $api->patch('user', 'UsersController@update')->name('api.user.update');
            //图片资源上传
            $api->post('images', 'ImagesController@store')->name('api.images.store');
        });
    });

});

$api->version('v2', function ($api) {
    $api->get('version', function () {
        return response('this is version v2');
    });
});

