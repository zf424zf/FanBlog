<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        $userIds = \App\Models\User::all()->pluck('id')->toArray();

        $topices = \App\Models\Topic::all()->pluck('id')->toArray();

        $faker = app(Faker\Generator::class);
        $replys = factory(Reply::class)->times(50)->make()->each(function ($reply, $index) use ($faker, $userIds, $topices) {
            $reply->topic_id = $faker->randomElement($topices);

            $reply->user_id = $faker->randomElement($userIds);
        });
        Reply::insert($replys->toArray());
    }

}

