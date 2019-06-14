<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\PageBlock;

class CreatePageBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_blocks', function (Blueprint $table) {
          $table->increments('id');
          $table->enum('type', PageBlock::$types)->default(PageBlock::TYPE_LEVEL_2);

          $table->string('title', 255);

          $table->text('md')->nullable();
          $table->text('html')->nullable();

          $table->unsignedInteger('order')->default(1);

          $table->unsignedInteger('parent_id')->nullable();

          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_blocks');
    }
}
