<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMomentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moments', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('content');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('status')->unsigned()->default(1);
            $table->integer('like_cnt')->unsigned()->default(0);
            $table->integer('comment_cnt')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moments');
    }
}
