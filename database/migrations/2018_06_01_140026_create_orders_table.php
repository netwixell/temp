<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Order;

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
            $table->bigIncrements('id');
            $table->enum('status', Order::$statuses)->default(Order::STATUS_NEW);
            $table->unsignedInteger('ticket_id');
            $table->unsignedDecimal('total_price',13,2);
            $table->enum('payment_type', Order::$payment_types)->default(Order::PAYMENT_CASH);
            $table->string('name',255);
            $table->string('email',255)->nullable();
            $table->string('phone',255);
            $table->string('city',255)->nullable();
            $table->text('comment')->nullable();
            $table->text('notation')->nullable();

            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
