<?php
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRoleTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creates the permission_role (Many-to-Many relation) table
        Schema::create('permission_role', function($table)
        {
            $table->increments('id');
            $table->integer('permission_id')->unsigned()->index();
            $table->integer('role_id')->unsigned()->index();
            $table->unique(array('permission_id','role_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permission_role');
    }

}
