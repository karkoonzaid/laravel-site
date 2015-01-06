<?php

use Acme\Subscription\SubscriptionRepository;

class AdminStatusesController extends AdminBaseController {


    /**
     * @var Acme\Subscription\SubscriptionRepository
     */
    private $subscriptionRepository;

    function __construct(SubscriptionRepository $subscriptionRepository)
    {
        parent::__construct();
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function index()
    {
        $requests = $this->subscriptionRepository->getAll(['user,event']);
        dd($requests);

        $requests = $this->status->with(array('user', 'event'))->latest()->get();

        return View::make('admin.requests.index', compact('requests'));
    }

    public function create(StatusInterface $repo)
    {
        $this->repo = $repo;

        return $this;
    }

    public function edit($id)
    {
        $request = $this->status->with(array('user', 'event'))->find($id);

        if ( is_null($request) ) {
            return parent::redirectToAdmin();
        }

        return View::make('admin.requests.edit', compact('request'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $setStatus = Input::get('status');
        $reason    = Input::get('body');
        $status    = $this->status->findOrFail($id);
        $event     = $this->event->findOrFail($status->event_id);
        $user      = $this->user->findOrFail($status->user_id);
        // filter the input value ..
        // make the input value classname convention
        // instantiate the class
        // set status
        $class = 'Acme\\Repo\\Statuses\\' . ucfirst(strtolower($setStatus));

        return $this->create(new $class)->setStatus($event, $user, $status, $reason);
    }

    public function destroy($id)
    {
        $status = $this->status->findOrFail($id);
        $event  = $this->event->findOrFail($status->event_id);
        $user   = $this->user->findOrFail($status->user_id);
        if ( $status->find($id)->delete() ) {
            $event->subscriptions()->detach($user);
            $event->updateSeats();

            return Redirect::action('AdminStatusesController@index')->with(array('success' => 'Request Deleted'));
        } else {
            return Redirect::action('AdminStatusesController@index')->with(array('error' => 'Request Could not be Deleted'));
        }

    }

    /**
     * @param $event
     * @param $user
     * @param $status
     * @return mixed
     * Set the Status of an Event
     */
    public function setStatus($event, $user, $status, $reason)
    {
        return $this->repo->setAction($event, $user, $status, $reason);
    }

}