<?php

use Carbon\Carbon;

class EventsTableSeeder extends Seeder {

    protected $date_start;
    protected $date_end;

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('events')->truncate();
        $faker = Faker\Factory::create();
        $dt = Carbon::now();
        $dateNow = $dt->toDateTimeString();

        for ($i = 0; $i < 10; $i++)
        {
            $this->setDateStart($dt->addDays($faker->numberBetween(1,20))->toDateTimeString());

            $this->setDateEnd($dt->addDays($faker->numberBetween(2,20))->toDateTimeString());

            $this->checkDate();

            $category = App::make('\Acme\Category\CategoryRepository')->getEventCategories()->orderBY(DB::raw('RAND()'))->first()->id;
            $user = User::orderBy(DB::raw('RAND()'))->first()->id;
            $location = Location::orderBy(DB::raw('RAND()'))->first()->id;
            $max_seats = 15;
            $total_seats = $faker->numberBetween(1,$max_seats);
            $available_seats = $max_seats - $total_seats;
            $events = array(
                [
                    'category_id' => $category,
                    'user_id' => $user,
                    'location_id' => $location,
                    'title_en' => 'Kaizen Events',
                    'title_ar' => 'كايزن ',
                    'description_en'=>$faker->sentence(20),
                    'description_ar' => $faker->sentence(20),
                    'price'=> '440',
                    'total_seats' => $total_seats,
                    'available_seats' => $available_seats,
                    'slug'=> $faker->sentence(10),
                    'date_start' =>$this->getDateStart(),
                    'date_end' => $this->getDateEnd(),
                    'phone' => '98989',
                    'email'=>$faker->email,
                    'address_en' => $faker->address,
                    'address_ar' => $faker->address,
                    'street_en' => $faker->streetAddress,
                    'street_ar' => $faker->streetAddress,
                    'latitude' => $faker->latitude,
                    'longitude' => $faker->longitude,
                    'featured'=>(bool) rand(0,1),
                    'created_at' => $dateNow,
                    'updated_at' => $dateNow,
                    'button_en'=>'Subscribe',
                    'button_ar' => 'سجل'
                ]

		    );
            DB::table('events')->insert($events);

        }

//		 Uncomment the below to run the seeder
	}

    /**
     * @return mixed
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    /**
     * @param mixed $date_start
     */
    public function setDateStart($date_start)
    {
        $this->date_start = $date_start;
    }

    /**
     * @return mixed
     */
    public function getDateEnd()
    {
        return $this->date_end;
    }

    /**
     * @param mixed $date_end
     */
    public function setDateEnd($date_end)
    {
        $this->date_end = $date_end;
    }

    function checkDate() {
        if($this->getDateEnd() > $this->getDateStart()) {
            return $this->setDateEnd($this->getDateEnd());
        } else {
            return $this->checkdate();
        }
    }
}
