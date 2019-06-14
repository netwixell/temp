<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleSpeakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_speakers', function (Blueprint $table) {
            $table->unsignedInteger('schedule_id');
            $table->unsignedInteger('speaker_id');

            $table->primary(['schedule_id','speaker_id']);

            $table->foreign('schedule_id')
            ->references('id')->on('schedule')
            ->onDelete('cascade');
            $table->foreign('speaker_id')
            ->references('id')->on('speakers')
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
        Schema::dropIfExists('schedule_speakers');
    }
}
