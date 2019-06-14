<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_cards', function (Blueprint $table) {
            $table->unsignedInteger('ticket_id');
            $table->unsignedInteger('card_id');

            $table->primary(['ticket_id','card_id']);

            $table->foreign('ticket_id')
            ->references('id')->on('tickets')
            ->onDelete('cascade');
            $table->foreign('card_id')
            ->references('id')->on('cards')
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
        Schema::dropIfExists('ticket_cards');
    }
}
