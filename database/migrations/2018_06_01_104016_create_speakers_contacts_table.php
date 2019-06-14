<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\SpeakerContact;

class CreateSpeakersContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speakers_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('speaker_id');
            $table->enum('type', SpeakerContact::$types)->default(SpeakerContact::TYPE_FACEBOOK);
            $table->string('value',255);
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
        Schema::dropIfExists('speakers_contacts');
    }
}
