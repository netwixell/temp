<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageBlocksRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_blocks_relations', function (Blueprint $table) {
          $table->unsignedInteger('page_id');
          $table->unsignedInteger('page_block_id');

          $table->primary(['page_id','page_block_id']);

          $table->foreign('page_id')
          ->references('id')->on('pages')
          ->onDelete('cascade');
          $table->foreign('page_block_id')
          ->references('id')->on('page_blocks')
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
        Schema::dropIfExists('page_blocks_relations');
    }
}
