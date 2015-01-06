<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ads', function(Blueprint $table)
		{
            $table->increments('id');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('url');
            $table->boolean('active')->default('0')->nullable();
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
		Schema::table('ads', function(Blueprint $table)
		{
			//
            $table->drop();
		});
	}

}
