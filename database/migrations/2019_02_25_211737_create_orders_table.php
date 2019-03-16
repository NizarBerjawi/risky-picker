<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('type_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->primary(['type_id', 'user_id']);
        });

        Schema::table('orders', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_id')->references('id')->on('order_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function(Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['type_id']);
        });

        Schema::dropIfExists('orders');
    }
}
