<?php

use Acme\Tag\TagRepository;

class AdminTagsController extends AdminBaseController {

	/**
	 * Country Repository
	 *
	 * @var Country
	 */
	protected $tagRepository;

    /**
     * @param TagRepository $countryRepository
     */
    public function __construct(TagRepository $tagRepository)
	{
		$this->tagRepository = $tagRepository;
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
		$tags = $this->tagRepository->getAll();

		$this->render('admin.tags.index', compact('tags'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->render('admin.tags.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $val = $this->tagRepository->getCreateForm();

        if ( ! $val->isValid() ) {
            return Redirect::back()->withInput()->withErrors($val->getErrors());
        }

        if ( ! $record = $this->tagRepository->create($val->getInputData()) ) {
            return Redirect::back()->with('errors', $this->tagRepository->errors())->withInput();
        }

        return Redirect::action('AdminTagsController@index')->with('success','Tag Created');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tag = $this->tagRepository->findOrFail($id);

		$this->render('admin.tags.show', compact('tag'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tag = $this->tagRepository->findById($id);

		if (is_null($tag))
		{
			return Redirect::route('tags.index');
		}

		$this->render('admin.tags.edit', compact('tag'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $this->tagRepository->findById($id);

        $val = $this->tagRepository->getEditForm($id);

        if ( ! $val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( ! $this->tagRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->tagRepository->errors())->withInput();
        }

        return Redirect::action('AdminTagsController@index')->with('success', 'Tag Updated');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->tagRepository->findById($id)->delete();

		return Redirect::action('AdminTagsController@index')->with('success','Tag Deleted');
	}

}
