<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMobileColumnFromUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        DB::statement('alter table users modify column mobile varchar(100)');
        DB::statement('alter table users modify column phone varchar(100)');
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		 Schema::table('users', function($table)
        {
            DB::statement('ALTER TABLE users MODIFY  column mobile BIGINT  ');
            DB::statement('ALTER TABLE users MODIFY  column phone BIGINT ');
        });
	}

}
