<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('team_id');

            $table->string('image',255);
            $table->string('caption',255)->nullable();

            $table->unsignedInteger('order')->default(1);


            $table->timestamps();

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
        Schema::dropIfExists('team_photos');
    }
}
