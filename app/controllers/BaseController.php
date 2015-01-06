<?php

abstract class BaseController extends Controller {

    // define the master layout for the site
    protected $layout = 'site.master';

    // title of the page
    protected $title = '';

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => array('post', 'delete', 'put')));
        $this->initSidebarPosts();
        $this->initRegion();
    }

    protected function setupLayout()
    {
        if ( !is_null($this->layout) ) {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * @param $path
     * @param array $data
     * render the view
     */
    protected function render($path, $data = [])
    {
        $this->layout->title   = $this->title;
        $this->layout->content = View::make($path, $data);
    }

    /**
     * Get User's Country and Set It as his default Country
     * @todo Cache Request
     */
    public function initRegion()
    {
        View::composer('site.partials.region', function ($view) {
            $countryRepository  = App::make('Acme\Country\CountryRepository');
            $selectedCountry    = $countryRepository->setRegion();
            $availableCountries = $countryRepository->availableCountries();
            $view->with(compact('selectedCountry', 'availableCountries'));
        });
    }

    /**
     * Get Latest Posts For Events, Category
     * Sidebar Widgets
     */
    public function initSidebarPosts()
    {
        View::composer('site.events._latest', function ($view) {
            $latest_event_posts = App::make('EventModel')->latest(4);
            $view->with(array('latest_event_posts' => $latest_event_posts));
        });
        View::composer('site.blog._latest', function ($view) {
            $latest_blog_posts = App::make('Blog')->latest(4);
            $view->with(array('latest_blog_posts' => $latest_blog_posts));
        });
    }


}