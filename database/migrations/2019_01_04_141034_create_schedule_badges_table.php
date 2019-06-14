<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_badges', function (Blueprint $table) {
          $table->unsignedInteger('schedule_id');
          $table->unsignedInteger('badge_id');

          $table->primary(['schedule_id','badge_id']);

          $table->foreign('schedule_id')
          ->references('id')->on('schedule')
          ->onDelete('cascade');
          $table->foreign('badge_id')
          ->references('id')->on('badges')
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
        Schema::dropIfExists('schedule_badges');
    }
}
