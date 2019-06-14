<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\JudgeVote;

class CreateJudgeVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('judge_votes', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedInteger('judge_poll_id');
          $table->unsignedInteger('team_id');

          $table->enum('criterion', JudgeVote::$criteria)->default(JudgeVote::CRITERION_COMPLEXITY);
          $table->unsignedTinyInteger('score');


          $table->foreign('judge_poll_id')
          ->references('id')->on('judge_polls')
          ->onDelete('cascade');
          $table->foreign('team_id')
          ->references('id')->on('teams')
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
        Schema::dropIfExists('judge_votes');
    }
}
