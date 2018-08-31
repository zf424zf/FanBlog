<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('env', function () {
//    $sms = app('easysms');
//    try {
//        $sms->send(18705191169, [
//            'content'  => '【FanBBS博客】您的验证码是1234。如非本人操作，请忽略本短信',
//        ]);
//    } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
//        $message = $exception->getException('yunpian')->getMessage();
//        dd($message);
//    }
    phpinfo();
});
Route::get('/', 'TopicsController@index')->name('root');
Route::get('test', function () {
    $time = \Carbon\Carbon::now()->toDateTimeString();
    return md5(1 . $time . str_random(16));
});
Auth::routes();

Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);

Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');
Route::get('reg/token/{token}', 'UsersController@validateRegToken');

Route::resource('moment', 'MomentController', ['only' => ['index', 'show', 'destroy']]);