<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoffeeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coffee_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('coffee_id')->unsigned();
            $table->integer('sugar')->default(0);
            $table->string('start_time');
            $table->string('end_time');
            $table->json('days');
        });

        Schema::table('coffee_user', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('coffee_id')->references('id')->on('coffees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coffee_user', function(Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['coffee_id']);
        });

        Schema::dropIfExists('coffee_user');
    }
}
