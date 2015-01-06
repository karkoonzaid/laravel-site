<?php

use Acme\Category\CategoryRepository;

class AdminCategoriesController extends AdminBaseController {

	/**
	 * Category Repository
	 *
	 * @var Category
	 */
	protected $categoryRepository;

	public function __construct(CategoryRepository $categoryRepository)
	{
		$this->categoryRepository = $categoryRepository;
        $this->beforeFilter('Admin');
        parent::__construct();
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$categories = $this->categoryRepository->getAll();

		return $this->render('admin.categories.index', compact('categories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return $this->render('admin.categories.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $val = $this->categoryRepository->getCreateForm();

        if ( ! $val->isValid() ) {
            return Redirect::back()->withInput()->withErrors($val->getErrors());
        }

        if ( ! $record = $this->categoryRepository->create($val->getInputData()) ) {
            return Redirect::back()->with('errors', $this->categoryRepository->errors())->withInput();
        }

        return Redirect::action('AdminCategoriesController@index')->with('success','Category Created');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$category = $this->categoryRepository->findById($id);

		return $this->render('admin.categories.show', compact('category'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$category = $this->categoryRepository->findById($id);

		if (is_null($category))
		{
			return Redirect::route('admin.categories.index');
		}

		return $this->render('admin.categories.edit', compact('category'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $this->categoryRepository->findById($id);

        $val = $this->categoryRepository->getEditForm($id);

        if ( ! $val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( ! $this->categoryRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->categoryRepository->errors())->withInput();
        }

        return Redirect::action('AdminCategoriesController@index')->with('success', 'Updated');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->categoryRepository->findById($id)->delete();

		return Redirect::action('AdminCategoriesController@index');
	}


    public function getEvents($id){
        $events = $this->categoryRepository->findById($id)->events;
        return $events;
    }

    public function getPosts($id){
        $posts = $this->categoryRepository->findById($id)->posts;
        return $posts;
    }
}
