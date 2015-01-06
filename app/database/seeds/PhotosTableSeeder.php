<?php


class PhotosTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 DB::table('photos')->truncate();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 50; $i++)
        {
            $event = EventModel::orderBy(DB::raw('RAND()'))->first()->id;

            $images = array(

                [
                    'name' => $faker->imageUrl(120,120),
                    'imageable_id' => $event,
                    'imageable_type' => $faker->randomElement(['EventModel','Blog']),
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime

                ]
            );
//            DB::table('photos')->insert($images);

        }
		// Uncomment the below to run the seeder
	}

}
