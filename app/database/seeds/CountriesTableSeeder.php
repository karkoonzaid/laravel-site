<?php

class CountriesTableSeeder extends Seeder {

	public function run()
	{
        DB::table('countries')->truncate();

        $countries = array(
            array(
                'name_ar' => 'الكويت',
                'name_en' =>'Kuwait',
                'currency' =>'KWD',
                'iso_code' =>'KW',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'name_ar' => 'السعودية',
                'name_en' =>'Saudi',
                'currency' =>'SAR',
                'iso_code' =>'SA',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'name_ar' => 'عمان',
                'name_en' =>'Oman',
                'currency' =>'',
                'iso_code' =>'',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'name_ar' => 'الإمارات',
                'name_en' =>'UAE',
                'currency' =>'AED',
                'iso_code' =>'AE',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'name_ar' => 'قطر',
                'name_en' =>'Qatar',
                'currency' =>'QAR',
                'iso_code' =>'QA',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'name_ar' => 'بحرين',
                'name_en' =>'Bahrain',
                'currency' =>'BHD',
                'iso_code' =>'BAH',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
        );
        DB::table('countries')->insert($countries);

    }

}
