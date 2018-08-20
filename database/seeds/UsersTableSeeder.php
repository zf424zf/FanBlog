<?php

use Illuminate\Database\Seeder;
use App\Models\User as UserModel;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //加载faker对象
        $faker = app(Faker\Generator::class);

        //提供6个随机头像
        $avatars = [
            'http://fanbbs.loc/upload/images/avatars/201808/15/1_1534337160_Bd9gjl31Hd.jpg',
            'http://fanbbs.loc/upload/images/avatars/201808/15/1_1534337168_JfIEIebaoH.jpg',
            'http://fanbbs.loc/upload/images/avatars/201808/15/1_1534337173_2doF8RlT4g.jpg',
            'http://fanbbs.loc/upload/images/avatars/201808/15/1_1534337180_Y1UjM6nLPz.jpg',
            'http://fanbbs.loc/upload/images/avatars/201808/15/1_1534337186_AIhyprQnBU.jpg',
            'http://fanbbs.loc/upload/images/avatars/201808/15/1_1534337192_NHI3XbtdcS.jpg',
        ];
        //根据指定的 User 生成模型工厂构造器，对应加载 UserFactory.php 中的工厂设置。
        $users = factory(UserModel::class)
            ->times(10)//生成 10 个用户数据。
            ->make()->each(function ($user, $index) use ($faker, $avatars) {
                //生成集合对象然后遍历每个对象 给头像赋值
                $user->avatar = $faker->randomElement($avatars);
            });

        //显示 User 模型 $hidden 属性里指定隐藏的字段，
        $userArr = $users->makeVisible(['password','remember_token'])->toArray();

        UserModel::insert($userArr);

        $user = UserModel::find(1);
        $user->name = 'fan';
        $user->email = '704273241@qq.com';
        $user->avatar = 'http://fanbbs.loc/upload/images/avatars/201808/15/1_1534337186_AIhyprQnBU.jpg';
        $user->save();

        //设置为站长
        $user->assignRole('Founder');

        // 将2号用户指派为管理员
        $user = \App\Models\User::find(2);
        $user->assignRole('Maintainer');
    }
}
