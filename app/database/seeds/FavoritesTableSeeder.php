<?php

class FavoritesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('favorites')->truncate();
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 30; $i++)
        {

            $event = EventModel::orderBy(DB::raw('RAND()'))->first()->id;
            $user = User::orderBy(DB::raw('RAND()'))->first()->id;

            $favorites = array(
                [
                    'user_id'=> $user,
                    'event_id' => $event,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ]
            );
            DB::table('favorites')->insert($favorites);

        }

		// Uncomment the below to run the seeder
	}

}
