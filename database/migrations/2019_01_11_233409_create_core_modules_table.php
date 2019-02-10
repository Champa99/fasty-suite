<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_modules', function (Blueprint $table) {

            // Set the database variables
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_unicode_ci';

			// Provide the fields we're gonna use
            $table->smallIncrements('id');
			$table->string('name', 128)->unique();
			$table->string('version', 20);
			$table->string('cycle', 20);
			$table->string('type', 20);
			$table->string('author', 25);
			$table->string('website', 128);
			$table->integer('installed_on');
            $table->integer('updated_on');
            $table->string('picture', 255)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_modules');
    }
}
