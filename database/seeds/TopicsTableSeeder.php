<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User as UserModel;
use App\Models\Category as CategoryModel;
class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        //获取当前所有用户的id
        $userIds = UserModel::all()->pluck('id')->toArray();

        //获取所有帖子分类id
        $categoryIds = CategoryModel::all()->pluck('id')->toArray();

        //获取faker实例化对象
        $faker = app(Faker\Generator::class);


        $topics = factory(Topic::class)->times(100)->make()->each(function ($topic, $index) use ($userIds,$categoryIds,$faker) {
            // 从用户 ID 数组中随机取出一个并赋值
            $topic->user_id = $faker->randomElement($userIds);

            // 话题分类，同上
            $topic->category_id = $faker->randomElement($categoryIds);
        });

        Topic::insert($topics->toArray());
    }

}

