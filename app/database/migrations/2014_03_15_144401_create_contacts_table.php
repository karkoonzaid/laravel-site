<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->increments('id');
            $table->string('name_en');
            $table->string('name_ar');
			$table->text('address_en');
			$table->text('address_ar');
            $table->string('email');
            $table->integer('phone');
            $table->integer('mobile');
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
		Schema::drop('contacts');
	}

}
