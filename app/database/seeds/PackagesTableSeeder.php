<?php

class PackagesTableSeeder extends Seeder {
    public function run()
    {
        DB::table('packages')->truncate();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 1; $i++)
        {
            $sentence = $faker->sentence(5);
            $slug = Str::slug($sentence);

            $user = User::orderBy(DB::raw('RAND()'))->first()->id;
            $category = Category::orderBy(DB::raw('RAND()'))->first()->id;
            $posts = array(
                [
                    'title_en'      => $sentence,
                    'title_ar'      => $sentence,
                    'description_en'      => $sentence,
                    'description_ar'      => $sentence,
                    'price'      => '30',
                    'free'      => 0,
                    'created_at' => $faker->DateTime(),
                    'updated_at' => $faker->DateTime()
                ]
            );
            DB::table('packages')->insert($posts);
        }
    }

}
