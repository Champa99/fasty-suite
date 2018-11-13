<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_routes', function (Blueprint $table) {

			// Set the database variables
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_unicode_ci';

			// Provide the fields we're gonna use
			$table->increments('id');
			$table->string('method', 8);
			$table->string('uri', 255);
			$table->string('controller', 255);
			$table->boolean('isEnabled')->default(true);
			$table->smallInteger('perm_group');
			$table->tinyInteger('perm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_routes');
    }
}
