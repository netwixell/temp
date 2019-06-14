<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_votes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('poll_id');
            $table->unsignedInteger('team_id');

            $table->unsignedInteger('user_ip');
            $table->string('user_agent', 255);

            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online_votes');
    }
}
