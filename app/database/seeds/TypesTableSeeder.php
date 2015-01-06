<?php

class TypesTableSeeder extends Seeder {
	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 DB::table('subscriptions')->truncate();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 40; $i++)
        {

            $event = EventModel::orderBy(DB::raw('RAND()'))->first()->id;

            $subscriptions = array(
                [
                    'event_id' => $event,
                    'type' => $faker->randomElement(['FREE','PAID']),
                    'approval_type' =>  $faker->randomElement(['DIRECT','MOD']),
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ]
            );
            DB::table('types')->insert($subscriptions);

        }
		// Uncomment the below to run the seeder

//        $this->updateEventsTable();
	}

    public function updateEventsTable() {
        $events  = EventModel::all();
        foreach ($events as $event) {
            $count = Subscription::findEventCount($event->id);
            EventModel::fixEventCounts($event->id,$count);
        }
    }

}
