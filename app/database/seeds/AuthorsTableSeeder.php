<?php

class AuthorsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 DB::table('authors')->truncate();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 40; $i++)
        {

            $event = EventModel::orderBy(DB::raw('RAND()'))->first()->id;
            $user = User::orderBy(DB::raw('RAND()'))->first()->id;

            $authors = array(
                [
                    'user_id'=> $user,
                    'event_id' => $event,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ]
            );
	        // Uncomment the below to run the seeder
		    DB::table('authors')->insert($authors);
        }
	}

}
