<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Callback;

class CreateCallbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('callback', function(Blueprint $table)
        {
          $table->increments('id');
          $table->enum('status',Callback::$statuses)->default(Callback::STATUS_NEW);
          $table->string('name',255);
          $table->string('phone',55);
          $table->string('email',255);
          $table->text('question', 65535)->nullable();
          $table->text('note', 65535)->nullable();

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
        Schema::dropIfExists('callback');
    }
}
