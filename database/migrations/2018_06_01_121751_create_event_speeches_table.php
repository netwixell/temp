<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventSpeechesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_speeches', function (Blueprint $table) {
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('speech_id');

            $table->primary(['event_id','speech_id']);

            $table->foreign('event_id')
            ->references('id')->on('events')
            ->onDelete('cascade');
            $table->foreign('speech_id')
            ->references('id')->on('speeches')
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
        Schema::dropIfExists('event_speeches');
    }
}
