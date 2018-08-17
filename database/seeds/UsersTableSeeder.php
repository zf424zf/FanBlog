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
            'http://fanbbs.loc/upload/images/avatars/201808/17/1_1534490306_9UkA7KmIaM.jpg',
            'http://fanbbs.loc/upload/images/avatars/201808/17/1_1534490300_8zRdB5bQOt.jpg',
            'http://fanbbs.loc/upload/images/avatars/201808/17/1_1534490294_t3JCNxP9cy.jpg',
            'http://fanbbs.loc/upload/images/avatars/201808/17/1_1534490288_iZSxwFeVwY.jpg',
            'http://fanbbs.loc/upload/images/avatars/201808/17/1_1534490281_HarCrQCxzD.jpg',
            'http://fanbbs.loc/upload/images/avatars/201808/17/1_1534490272_JTi1iWrOlQ.jpg',
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
        $user->avatar = 'http://fanbbs.loc/upload/images/avatars/201808/17/1_1534490306_9UkA7KmIaM.jpg';
        $user->save();


    }
}
