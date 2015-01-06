<?php

use Carbon\Carbon;

class EventsTableSeeder extends Seeder {

    protected $date_start;
    protected $date_end;

    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('events')->truncate();
        $faker   = Faker\Factory::create();
        $dt      = Carbon::now();
        $dateNow = $dt->toDateTimeString();

        for ( $i = 0; $i < 1; $i ++ ) {
            $startDate = $dt->addYear(2)->toDateTimeString();

            $endDate = $dt->addYear(3)->toDateTimeString();

            $category = App::make('\Acme\Category\CategoryRepository')->getEventCategories()->orderBY(DB::raw('RAND()'))->first()->id;
            $user     = User::orderBy(DB::raw('RAND()'))->first()->id;
            $location = Location::orderBy(DB::raw('RAND()'))->first()->id;
            $events   = array(
                [
                    'category_id'    => $category,
                    'user_id'        => $user,
                    'location_id'    => $location,
                    'title_en'       => 'Kaizen Events',
                    'title_ar'       => 'كايزن ',
                    'description_en' => $faker->sentence(20),
                    'description_ar' => $faker->sentence(20),
                    'slug'           => $faker->sentence(10),
                    'date_start'     => $startDate,
                    'date_end'       => $endDate,
                    'phone'          => '0096597978805',
                    'email'          => $faker->email,
                    'address_en'     => $faker->address,
                    'address_ar'     => $faker->address,
                    'street_en'      => $faker->streetAddress,
                    'street_ar'      => $faker->streetAddress,
                    'latitude'       => $faker->latitude,
                    'longitude'      => $faker->longitude,
                    'featured'       => (bool) rand(0, 1),
                    'free'           => '0',
                    'created_at'     => $dateNow,
                    'updated_at'     => $dateNow,
                    'button_en'      => 'Subscribe',
                    'button_ar'      => 'سجل'
                ]

            );
            DB::table('events')->insert($events);

        }

//		 Uncomment the below to run the seeder
    }

}