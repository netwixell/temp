<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDeadlineNullableToInstallments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Schema::table('installments', function (Blueprint $table) {
      //   $table->unsignedTinyInteger('deadline', 255)->default(7)->nullable()->change();
      // });

      DB::statement("
      ALTER TABLE `installments`
      CHANGE `deadline` `deadline` TINYINT(255) UNSIGNED DEFAULT '7'
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
