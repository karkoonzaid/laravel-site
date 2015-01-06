<?php

class SettingsTableSeeder extends Seeder {
	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 DB::table('settings')->truncate();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 1; $i++)
        {

            $event = EventModel::orderBy(DB::raw('RAND()'))->first()->id;
            $user = User::orderBy(DB::raw('RAND()'))->first()->id;

            $subscriptions = array(
                [
                    'approval_type'=> 'DIRECT',
                    'registration_types' => 'VIP,ONLINE',
                    'settingable_id' => '1',
                    'settingable_type' => 'EventModel',
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ]
            );
            DB::table('settings')->insert($subscriptions);

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
