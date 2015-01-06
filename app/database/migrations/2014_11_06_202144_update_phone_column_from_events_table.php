<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePhoneColumnFromEventsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('alter table contacts modify column mobile varchar(100)');
        DB::statement('alter table contacts modify column phone varchar(100)');
        DB::statement('alter table events modify column phone varchar(100)');
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
            DB::statement('ALTER TABLE contacts MODIFY  column mobile INT  ');
            DB::statement('ALTER TABLE contacts MODIFY  column phone INT  ');
            DB::statement('ALTER TABLE events MODIFY  column phone INT ');
        });
    }

}
