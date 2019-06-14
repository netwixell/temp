<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->string('title',255);
            $table->unsignedInteger('flow_id')->nullable();
            $table->date('start_date');

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->string('options',255)->nullable();

            $table->text('description')->nullable();

            $table->timestamps();

            $table->foreign('flow_id')
            ->references('id')->on('flows')
            ->onDelete('cascade');

            $table->foreign('event_id')
            ->references('id')->on('events')
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
        Schema::dropIfExists('schedule');
    }
}
