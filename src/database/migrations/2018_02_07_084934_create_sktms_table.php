<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSktmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('sktms', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nomor_un');
			$table->integer('master_sktm_id')->nullable();
			$table->string('no_sktm');
			$table->integer('nilai')->nullable();
			$table->integer('user_id')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down()
	{
		Schema::drop('sktms');
	}
}
