<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageAdvertisementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_advertisement', function (Blueprint $table) {
            $table->unsignedInteger('page_id');
            $table->unsignedInteger('advertisement_id');

            $table->primary(['page_id','advertisement_id']);

            $table->foreign('page_id')
            ->references('id')->on('pages')
            ->onDelete('cascade');
            $table->foreign('advertisement_id')
            ->references('id')->on('advertisement')
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
        Schema::dropIfExists('page_advertisement');
    }
}
