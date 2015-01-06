<?php

use Carbon\Carbon;

class PostsTableSeeder extends Seeder {
    public function run()
    {
        DB::table('posts')->truncate();
        $dt = Carbon::now();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 1; $i++)
        {
            $sentence = $faker->sentence(5);
            $slug = Str::slug($sentence);

            $user = User::orderBy(DB::raw('RAND()'))->first()->id;
            $category = Category::orderBy(DB::raw('RAND()'))->first()->id;
            $posts = array(
                [
                    'user_id'    => $user,
                    'category_id'=> $category,
                    'title_ar'      => $sentence,
                    'title_en'      => $sentence,
                    'description_ar'    => $faker->sentence(200),
                    'description_en'    => $faker->sentence(200),
                    'created_at' => $dt,
                    'updated_at' => $dt
                ]
            );
            DB::table('posts')->insert($posts);
        }
    }

}
