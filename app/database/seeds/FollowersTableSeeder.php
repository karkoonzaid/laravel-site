<?php

class FollowersTableSeeder extends Seeder {

    protected $event;
    protected $user;

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 DB::table('followers')->truncate();
        $dt = Carbon::now();
        $dateNow = $dt->toDateTimeString();
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 40; $i++)
        {
            $this->setEvent(EventModel::orderBy(DB::raw('RAND()'))->first()->id);
            $this->setUser(User::orderBy(DB::raw('RAND()'))->first()->id);
//            $this->checkUnique();

            $followers = array(
                [
                    'user_id'=> $this->getUser(),
                    'event_id' => $this->getEvent(),
                    'created_at' => $dateNow,
                    'updated_at' => $dateNow
                ]
            );
            DB::table('followers')->insert($followers);

        }

		// Uncomment the below to run the seeder
	}

    private function checkUnique()
    {
        $query = Follower::where('event_id',$this->getEvent())->where('user_id',$this->getUser())->first();
        if(!$query) {
            return $this->setEvent($this->getEvent());
        } else {
            return $this->checkUnique();
        }
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $date_start
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $date_end
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }



}
