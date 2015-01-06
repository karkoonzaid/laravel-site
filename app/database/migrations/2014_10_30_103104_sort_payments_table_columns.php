<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SortPaymentsTableColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        DB::statement("ALTER TABLE payments MODIFY COLUMN token VARCHAR(255) AFTER status");
        DB::statement("ALTER TABLE payments MODIFY COLUMN payer_id VARCHAR(255) AFTER token");
        DB::statement("ALTER TABLE payments MODIFY COLUMN payment_id VARCHAR(255) AFTER payer_id");
        DB::statement("ALTER TABLE payments MODIFY COLUMN payment_token VARCHAR(255) AFTER payment_id");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DB::statement("ALTER TABLE payments MODIFY COLUMN token VARCHAR(255) AFTER status");
        DB::statement("ALTER TABLE payments MODIFY COLUMN payer_id VARCHAR(255) AFTER token");
        DB::statement("ALTER TABLE payments MODIFY COLUMN payment_id VARCHAR(255) AFTER payer_id");
        DB::statement("ALTER TABLE payments MODIFY COLUMN payment_token VARCHAR(255) AFTER payment_id");
	}

}
