<?php
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creates the users table
        Schema::create('users', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->boolean('active')->default(0);
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->integer('mobile')->nullable();
            $table->integer('phone')->nullable();
            $table->string('country_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->text('prev_event_comment')->nullable();
            $table->string('confirmation_code')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('last_logged_at')->nullable();
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
        Schema::drop('users');
    }

}
