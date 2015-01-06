<?php

class NewslettersController extends BaseController{

    protected $mc;
    protected $listId;

    public function init() {
        $this->setMc(new Mailchimp('107025e4b301304e9a4e226b1668b370-us3'));
    }

    public function subscribe()
    {
        $this->init();
        $this->setListId('76812be63e');
        $email = Input::get('email');

        if (isset($email) && !empty($email)) {
            try {
                $this->mc->lists->subscribe($this->listId,[ 'email' => $email]);
            }
            catch(Exception $e) {
                return Redirect::home()->with('warning',$e->getMessage());
            }
            return Redirect::home()->with('success', trans('general.newsletter_subscribed'));

        }

    }

    /**
     * @return mixed
     */
    public function getMc()
    {
        return $this->mc;
    }

    /**
     * @param mixed $mc
     */
    public function setMc($mc)
    {
        $this->mc = $mc;
    }

    /**
     * @return mixed
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * @param mixed $listId
     */
    public function setListId($listId)
    {
        $this->listId = $listId;
    }
}