<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_sessions', function (Blueprint $table) {

			// Set the database variables
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_unicode_ci';

			// Provide the fields we're gonna use
			$table->string('id', 255)->unique();
			$table->integer('user_id');
			$table->dateTime('created');
			$table->dateTime('expires');
			$table->string('agent', 255);
			$table->string('os', 15);
			$table->string('browser', 15);
			$table->string('browser_ver', 30);
			$table->string('ip', 128);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_sessions');
    }
}
