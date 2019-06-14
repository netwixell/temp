<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpeechesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speeches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug',255);
            $table->string('name',255);
            $table->text('preview')->nullable();
            $table->unsignedInteger('speaker_id');
            $table->text('content');
            $table->timestamps();

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
        Schema::dropIfExists('speeches');
    }
}
