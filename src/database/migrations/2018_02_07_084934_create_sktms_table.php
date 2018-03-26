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
			$table->integer('nomor_un');
			$table->integer('kode_sktm');
			$table->string('nama_suket');
			$table->string('instansi_suket');
			$table->integer('no_suket');
			$table->integer('nilai_sktm');
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
