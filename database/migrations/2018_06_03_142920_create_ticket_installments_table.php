<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_installments', function (Blueprint $table) {
            $table->unsignedInteger('ticket_id');
            $table->unsignedInteger('installment_id');

            $table->primary(['ticket_id','installment_id']);

            $table->foreign('ticket_id')
            ->references('id')->on('tickets')
            ->onDelete('cascade');
            $table->foreign('installment_id')
            ->references('id')->on('installments')
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
        Schema::dropIfExists('ticket_installments');
    }
}
