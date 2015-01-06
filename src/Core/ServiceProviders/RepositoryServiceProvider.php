<?php namespace Acme\Core\ServiceProviders;

use Acme\Contact\ContactEventSubscriber;
use Acme\EventModel\EventsEventSubscriber;
use Acme\Subscription\SubscriptionEventSubscriber;
use Acme\User\UserEventSubscriber;
use Illuminate\Support\ServiceProvider;
use Acme\User\EloquentUserRepository;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Register
     */
    public function boot()
    {
        $this->app['events']->subscribe(new UserEventSubscriber($this->app['mailer']));
        $this->app['events']->subscribe(new ContactEventSubscriber($this->app['mailer']));
        $this->app['events']->subscribe(new SubscriptionEventSubscriber($this->app['mailer']));
        $this->app['events']->subscribe(new EventsEventSubscriber($this->app['mailer']));
    }

    public function register()
    {

    }

}
