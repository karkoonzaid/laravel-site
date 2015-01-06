<?php

class EventCountryTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('event_countries')->truncate();
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 2; $i++)
        {
            $event = EventModel::orderBy(DB::raw('RAND()'))->first()->id;
            $country = [1,2];
            $favorites = array(
                [
                    'country_id'=> array_rand($country),
                    'event_id' => $event,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ]
            );
            DB::table('event_countries')->insert($favorites);

        }

		// Uncomment the below to run the seeder
	}

}
