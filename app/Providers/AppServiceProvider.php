<?php

namespace App\Providers;

use App\Http\Service\Category;
use App\Models\Like;
use App\Models\Link;
use App\Models\Menu;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use App\Observers\LikeObserver;
use App\Observers\LinkObserver;
use App\Observers\ReplyObserver;
use App\Observers\UserObserver;
use Carbon\Carbon;
use Dingo\Api\Transformer\Adapter\Fractal;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;

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

        //注册模型观察器
        Topic::observe(\App\Observers\TopicObserver::class);
        Reply::observe(ReplyObserver::class);
        Link::observe(LinkObserver::class);
        User::observe(UserObserver::class);
        Like::observe(LikeObserver::class);
        $menus = Menu::all()->toArray();
         dd(menuFormat($menus));
        //视图共享categories
        $categories = Category::getCategories();
        \View::share('categoriesList', $categories);
        //Fractal 格式化为 ArraySerializer
        $this->app['Dingo\Api\Transformer\Factory']->setAdapter(function ($app) {
            $fractal = new Manager;
            $fractal->setSerializer(new \League\Fractal\Serializer\ArraySerializer());
            return new Fractal($fractal);
        });
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
