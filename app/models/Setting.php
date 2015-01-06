<?php

use Acme\Core\LocaleTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use McCool\LaravelAutoPresenter\PresenterInterface;

class Setting extends BaseModel implements PresenterInterface {

    use LocaleTrait;

    use SoftDeletingTrait;

    protected $guarded = ['id'];

    protected $localeStrings = ['vip_benefits', 'online_benefits', 'normal_benefits', 'vip_description', 'online_description', 'normal_description'];

    protected $table = 'settings';

    protected $regTypes = ['VIP', 'ONLINE', 'NORMAL'];

    public function settingable()
    {
        return $this->morphTo();
    }

    public function getPresenter()
    {
        return 'Acme\Setting\Presenter';
    }

    /**
     * @param $type => { VIP, ONLINE, NORMAL }
     * @return \Acme\Core\localized
     */
    public function hasAvailableSeats($type)
    {
        $field = strtolower($type) . '_total_seats';

        return $this->$field > 0 ? true : false;
    }

    /**
     * @param array $validRegType [ VIP, ONLINE]
     */
    public function updateAvailableSeatsBulk(array $validRegType)
    {
        foreach ( $validRegType as $key => $type ) {
            $this->updateAvailableSeats($key);
        }
    }

    /**
     * @param $type => { VIP, ONLINE, NORMAL }
     * @return \Acme\Core\localized
     */
    public function updateAvailableSeats($type)
    {
        $totalSeat     = strtolower($type) . '_total_seats';
        $availableSeat = strtolower($type) . '_available_seats';

        // If Total Seats is Greater than 0
        // Which means is not unlimited seats
        if ( $this->$totalSeat > 0 ) {

            // Get the confirmed subscriptions count for the event
            $totalSubscriptions = $this->settingable->subscriptions()->where('status', 'CONFIRMED')->where('registration_type', $type)->count();

            // calculate the available seats
            $available_seats = $this->$totalSeat - $totalSubscriptions;

        } else {
            $available_seats = 0;
        }

        $this->$availableSeat = (int) ($available_seats);

        $this->save();
    }

}
