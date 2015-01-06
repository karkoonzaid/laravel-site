<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertAvailableSeatsToSettingsTbale extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('settings', function(Blueprint $table)
		{
			$table->integer('vip_available_seats')->default(0)->nullable();
			$table->integer('online_available_seats')->default(0)->nullable();
			$table->integer('normal_available_seats')->default(0)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('settings', function(Blueprint $table)
		{
			$table->dropColumn('vip_available_seats');
			$table->dropColumn('online_available_seats');
			$table->dropColumn('normal_available_seats');
		});
	}

}
