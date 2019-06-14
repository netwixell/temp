<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_partners', function (Blueprint $table) {
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('partner_id');

            $table->primary(['event_id','partner_id']);

            $table->foreign('event_id')
            ->references('id')->on('events')
            ->onDelete('cascade');
            $table->foreign('partner_id')
            ->references('id')->on('partners')
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
        Schema::dropIfExists('event_partners');
    }
}
