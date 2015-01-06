<?php

class AdminTypesController extends AdminBaseController {


    /**
     * Post Model
     * @var Post
     */
    protected $model;

    /**
     * Inject the models.
     * @param \Ad|\Type $model
     * @internal param \Photo $photo
     * @internal param \Post $post
     */
    public function __construct(Type $model)
    {
        $this->model = $model;
        parent::__construct();
        $this->beforeFilter('Admin');
    }

    public function store()
    {
        $validation = new $this->model(Input::all());
        if (!$validation->save())
        {
            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        return Redirect::home();
    }

}