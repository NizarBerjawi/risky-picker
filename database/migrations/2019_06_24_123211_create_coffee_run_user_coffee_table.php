<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoffeeRunUserCoffeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coffee_run_user_coffee', function (Blueprint $table) {
            $table->bigInteger('coffee_run_id')->unsigned();
            $table->bigInteger('user_coffee_id')->unsigned();
        });

        Schema::table('coffee_run_user_coffee', function(Blueprint $table) {
            $table->primary(['coffee_run_id', 'user_coffee_id']);
            $table->foreign('coffee_run_id')->references('id')->on('coffee_runs');
            $table->foreign('user_coffee_id')->references('id')->on('user_coffee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coffee_run_user_coffee', function(Blueprint $table) {
            $table->dropForeign(['user_coffee_id']);
            $table->dropForeign(['coffee_run_id']);
        });

        Schema::dropIfExists('coffee_run_user_coffee');
    }
}
