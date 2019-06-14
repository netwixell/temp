<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_options', function (Blueprint $table) {
            $table->unsignedInteger('ticket_id');
            $table->unsignedInteger('option_id');

            $table->primary(['ticket_id','option_id']);

            $table->foreign('ticket_id')
            ->references('id')->on('tickets')
            ->onDelete('cascade');
            $table->foreign('option_id')
            ->references('id')->on('options')
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
        Schema::dropIfExists('ticket_options');
    }
}
