<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPricesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_prices', function(Blueprint $table)
		{
			//
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('event_id')->unsigned()->index();
			$table->integer('country_id')->unsigned()->index();
			$table->string('price')->nullable();
			$table->string('type')->nullable();
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
		Schema::drop('event_prices');
	}

}
