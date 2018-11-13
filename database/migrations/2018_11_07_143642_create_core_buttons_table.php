<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreButtonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_buttons', function (Blueprint $table) {
            $table->smallIncrements('id');
			$table->string('lang_key', 128);
			$table->string('icon', 30);
			$table->string('url', 255)->nullable()->default(null);
			$table->smallInteger('parent')->nullable()->default(null);
			$table->tinyInteger('perm')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_buttons');
    }
}
