<?php

use Illuminate\Database\Seeder;
use App\Models\Moment;
class MomentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $userIds = \App\Models\User::all()->pluck('id')->toArray();

        $faker = app(Faker\Generator::class);

        $moments = factory(Moment::class)->times(60)->make()->each(function ($moment) use ($faker, $userIds) {
            $moment->user_id = $faker->randomElement($userIds);
        });
        Moment::insert($moments->toArray());
    }
}
