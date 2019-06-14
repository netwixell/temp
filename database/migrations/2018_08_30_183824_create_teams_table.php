<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Team;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id');

            $table->enum('status',Team::$statuses)->default(Team::STATUS_NEW);

            $table->string('name',255);
            $table->string('contact_name',255);
            $table->string('phone',255);

            $table->string('email',255);
            $table->string('city',255);

            $table->text('notice')->nullable();

            $table->timestamps();

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
        Schema::dropIfExists('teams');
    }
}
