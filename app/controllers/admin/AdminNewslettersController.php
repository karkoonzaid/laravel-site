<?php
/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 2/27/14
 * Time: 6:57 PM
 */

class AdminNewslettersController extends AdminBaseController{


    public function __contstruct() {
        parent::__construct();
        $this->beforeFilter('Admin');
    }

    public function send($data) {
        //@todo
        //send newsletter emai
        Notify::newsletterSubscribers($data);
    }
} 