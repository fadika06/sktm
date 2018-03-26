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
			$table->integer('user_id');
			$table->integer('master_sktm_id');
			$table->integer('nomor_un');
			$table->string('nama_lomba', 255)->nullable();
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
