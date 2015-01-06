<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('approval_type')->nullable(); // [CONFIRM,DIRECT]
            $table->string('registration_types')->nullable(); // [VIP, ONLINE]
            $table->text('normal_benefits_ar')->nullable();
            $table->text('normal_benefits_en')->nullable();
            $table->text('vip_description_en')->nullable();
            $table->text('vip_description_ar')->nullable();
            $table->text('vip_benefits_en')->nullable();
            $table->text('vip_benefits_ar')->nullable();
            $table->text('vip_price')->nullable();
            $table->text('online_description_en')->nullable();
            $table->text('online_description_ar')->nullable();
            $table->text('online_benefits_en')->nullable();
            $table->text('online_benefits_ar')->nullable();
            $table->string('online_price')->nullable();
            $table->string('online_room_id')->nullable();
            $table->morphs('settingable'); // [Event,Package]
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
		Schema::drop('settings');
	}

}
