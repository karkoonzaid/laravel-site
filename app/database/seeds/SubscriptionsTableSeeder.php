<?php

class SubscriptionsTableSeeder extends Seeder {
	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 DB::table('subscriptions')->truncate();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 2; $i++)
        {

            $event = EventModel::orderBy(DB::raw('RAND()'))->first()->id;
            $user = User::orderBy(DB::raw('RAND()'))->first()->id;

            $subscriptions = array(
                [
                    'user_id'=> $user,
                    'subscribable_id' => $event,
                    'subscribable_type' => $faker->randomElement(['Event','Package']),
                    'status' => '',
                    'registration_type' => $faker->randomElement(['VIP','ONLINE']),
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ]
            );
            DB::table('subscriptions')->insert($subscriptions);

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
