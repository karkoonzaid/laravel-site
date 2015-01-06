<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class TaggableTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 50) as $index)
		{
            $event = EventModel::orderBy(DB::raw('RAND()'))->first()->id;
            $tag = Tag::orderBy(DB::raw('RAND()'))->first()->id;

			$array =[
                'tag_id' => $tag,
                'taggable_id' => $event,
                'taggable_type' => 'EventModel'
			];
             DB::table('taggables')->insert($array);
		}
	}

}