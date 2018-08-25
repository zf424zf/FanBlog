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
    'namespace' => '\App\Http\Controllers\Api'
], function ($api) {
    $api->post('verificationCodes', 'VerificationCodesController@store')->name('api.verificationCodes.store');
    $api->post('users', 'UsersController@store')->name('api.users.store');
});

$api->version('v2', function ($api) {
    $api->get('version', function () {
        return response('this is version v2');
    });
});

