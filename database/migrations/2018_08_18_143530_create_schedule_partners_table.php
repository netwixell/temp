<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_partners', function (Blueprint $table) {
            $table->unsignedInteger('schedule_id');
            $table->unsignedInteger('partner_id');

            $table->primary(['schedule_id','partner_id']);

            $table->foreign('schedule_id')
            ->references('id')->on('schedule')
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
        Schema::dropIfExists('schedule_partners');
    }
}
