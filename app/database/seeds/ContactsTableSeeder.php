<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ContactsTableSeeder extends Seeder {

	public function run()
	{
        DB::table('contacts')->truncate();
        $faker = Faker::create();

        $contacts = array([
            'address_en' => $faker->address,
            'address_ar' => $faker->address,
            'email'   =>'z4ls@live.com',
            'phone'   => '53234',
            'mobile'  => '2122',
            'name_en'=> 'Kaizen Admin',
            'name_ar'=> 'Kaizen Admin'
        ]);
        DB::table('contacts')->insert($contacts);
	}

}