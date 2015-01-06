<?php

abstract class AdminBaseController extends BaseController
{
    protected $layout = 'admin.master';

    protected $select = [''=>'Select one'];

    public function __construct() {
        parent::__construct();
    }
}