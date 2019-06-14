<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\EventPerson;

class CreateEventPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_persons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('person_id');
            $table->unsignedInteger('flow_id')->nullable();


            $table->string('caption',255)->nullable();

            $table->enum('position', EventPerson::$positions)->default(EventPerson::POSITION_SPEAKER);

            $table->timestamps();

            $table->foreign('event_id')
            ->references('id')->on('events')
            ->onDelete('cascade');

            $table->foreign('person_id')
            ->references('id')->on('persons')
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
        Schema::dropIfExists('event_persons');
    }
}
