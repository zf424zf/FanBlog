<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    $sentence = $faker->sentence();

    //随机取本月一个时间点
    $updated_at = $faker->dateTimeThisMonth();
    //随机取本月一个早于updated_at时间点
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'title' => $sentence,
        'body' => $faker->text(),
        'excerpt' => $sentence,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
