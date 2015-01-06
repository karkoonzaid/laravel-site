<?php

class EventPriceTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('event_prices')->truncate();
        for ($i = 0; $i < 3; $i++)
        {

            $event = EventModel::orderBy(DB::raw('RAND()'))->first()->id;
            $country = ['1'=>1,'2'=>2];
            $price = [200,300,400,500,600];
            $registration_types = ['VIP'=>'VIP','NORMAL'=>'NORMAL','ONLINE'=>'ONLINE'];
            $k = array_rand($price);
            $favorites = array(
                [
                    'country_id'=> array_rand($country),
                    'event_id' => $event,
                    'price' => $price[$k],
                    'type' => array_rand($registration_types),
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ]
            );
            DB::table('event_prices')->insert($favorites);

        }

		// Uncomment the below to run the seeder
	}

}
