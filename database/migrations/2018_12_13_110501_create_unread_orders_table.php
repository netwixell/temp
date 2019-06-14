<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnreadOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unread_orders', function (Blueprint $table) {
          $table->unsignedBigInteger('order_id');
          $table->unsignedInteger('user_id');

          $table->primary(['order_id','user_id']);

          $table->dateTime('created_at');

          $table->foreign('order_id')
          ->references('id')->on('orders')
          ->onDelete('cascade');
          $table->foreign('user_id')
          ->references('id')->on('users')
          ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unread_orders');
    }
}
