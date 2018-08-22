<?php

use Illuminate\Database\Seeder;
use App\Models\Link;
class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //生成5条假数据
        $links = factory(Link::class)->times(5)->make();
        Link::insert($links->toArray());
    }
}
