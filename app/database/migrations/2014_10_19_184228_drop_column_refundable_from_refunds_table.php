<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnRefundableFromRefundsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('refunds', function(Blueprint $table)
		{
			//
            $table->dropColumn('refundable_id');
            $table->dropColumn('refundable_type');
            $table->string('status')->nullable(); // Rejected,Approved
            $table->integer('payment_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('refunds', function(Blueprint $table)
		{
            $table->morphs('refundable');
            $table->dropColumn('status');
            $table->dropColumn('payment_id');
		});
	}

}
