<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_discounts', function (Blueprint $table) {
            $table->unsignedInteger('ticket_id');
            $table->unsignedInteger('discount_id');

            $table->primary(['ticket_id','discount_id']);

            $table->foreign('ticket_id')
            ->references('id')->on('tickets')
            ->onDelete('cascade');
            $table->foreign('discount_id')
            ->references('id')->on('discounts')
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
        Schema::dropIfExists('ticket_discounts');
    }
}
