<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCoffeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_coffee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('coffee_id')->unsigned();
            $table->integer('sugar')->default(0);
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->json('days')->nullable();
            $table->boolean('is_adhoc')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('user_coffee', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('coffee_id')->references('id')->on('coffees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_coffee', function(Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['coffee_id']);
        });

        Schema::dropIfExists('user_coffee');
    }
}
