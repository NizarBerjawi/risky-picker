<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoffeeRunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coffee_runs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->boolean('user_busy')->default(false);
            $table->bigInteger('volunteer_id')->nullable()->unsigned();
            $table->text('signed_url')->nullable();
            $table->timestamps();
        });

        Schema::table('coffee_runs', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('volunteer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coffee_runs', function(Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('coffee_runs');
    }
}
