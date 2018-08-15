<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $categories = [
            [
                'name'        => '随心所欲',
                'description' => '啥都能说，畅所欲言',
            ],
            [
                'name'        => '教程',
                'description' => '分享你的技术经验',
            ],
            [
                'name'        => 'Q&A',
                'description' => '把你遇到的问题写上来吧',
            ],
            [
                'name'        => '新闻与公告',
                'description' => '网站新闻公告',
            ],
        ];
        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //清空数据
        DB::table('categories')->truncate();
    }
}
