<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Moment::class, function (Faker $faker) {
    $content = $faker->sentence;
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'content' => $content,
        'status' => 1,
        'updated_at' => $updated_at,
        'created_at' => $created_at
    ];
});