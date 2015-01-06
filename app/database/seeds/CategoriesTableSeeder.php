<?php


class CategoriesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
        DB::table('categories')->truncate();
        $faker = Faker\Factory::create();

            $categories = array(
                [
                    'name_ar' => 'دورة ا',
                    'name_en' => 'Category 1',
                    'type'=> 'EventModel',
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ],
                [
                    'name_ar' => 'شسشس',
                    'name_en' => 'Category 2',
                    'type'=>'Post',
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ],
                [
                    'name_ar' => 'شسيش',
                    'name_en' => 'Category 3',
                    'type'=>'EventModel',
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ],

            );
            DB::table('categories')->insert($categories);

		// Uncomment the below to run the seeder

	}

}
