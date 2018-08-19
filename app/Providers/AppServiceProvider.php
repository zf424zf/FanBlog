<?php

namespace App\Providers;

use App\Http\Service\Category;
use App\Observers\ReplyObserver;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //设置默认字符串长度
        \Schema::defaultStringLength(191);
        //设置carbon格式化语言为中文
        Carbon::setLocale('zh');
        //视图共享categories
        $categories = Category::getCategories();
        \View::share('categoriesList', $categories);
        //注册模型观察器
        \App\Models\Topic::observe(\App\Observers\TopicObserver::class);
        \App\Models\Reply::observe(ReplyObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
