<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePriceColumnsFromSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('settings', function(Blueprint $table)
		{
			$table->dropColumn('vip_price');
			$table->dropColumn('online_price');
			$table->integer('normal_total_seats');
			$table->integer('online_total_seats');
			$table->integer('vip_total_seats');
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
			$table->text('vip_price')->nullable();
			$table->text('online_price')->nullable();
			$table->dropColumn('normal_total_seats')->nullable();
			$table->dropColumn('vip_total_seats')->nullable();
			$table->dropColumn('online_total_seats')->nullable();
		});
	}

}
