<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\PostReaction;

class CreatePostReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_reactions', function (Blueprint $table) {

          $table->bigIncrements('id');
          $table->unsignedInteger('post_id');

          $table->enum('type', PostReaction::$types)->default(PostReaction::TYPE_LOVE);

          $table->unsignedInteger('user_ip')->nullable();
          $table->string('user_agent', 255)->nullable();

          $table->dateTime('created_at');

          $table->foreign('post_id')
          ->references('id')->on('posts')
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
        Schema::dropIfExists('reactions');
    }
}
