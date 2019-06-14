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
            $table->unsignedInteger('poll_id');
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('flow_id');

            $table->enum('criterion', JudgeVote::$criteria)->default(JudgeVote::CRITERION_COMPLEXITY);
            $table->unsignedTinyInteger('score');

            $table->dateTime('created_at');

            $table->foreign('poll_id')
            ->references('id')->on('polls')
            ->onDelete('cascade');
            $table->foreign('team_id')
            ->references('id')->on('teams')
            ->onDelete('cascade');
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
            $table->foreign('flow_id')
            ->references('id')->on('flows')
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
