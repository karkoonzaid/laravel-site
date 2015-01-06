<?php

use Acme\Blog\BlogRepository;
use Acme\Category\CategoryRepository;
use Acme\Photo\PhotoRepository;
use Acme\Tag\TagRepository;
use Acme\User\UserRepository;

class AdminBlogsController extends AdminBaseController {


    /**
     * Post Model
     * @var Post
     */
    protected $blogRepository;
    /**
     * @var Category
     */
    private $categoryRepository;
    /**
     * @var User
     */
    private $userRepository;
    /**
     * @var Photo
     */
    private $photoRepository;
    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * Inject the models.
     * @param \Acme\Blog\BlogRepository|\Post $blogRepository
     * @param CategoryRepository|\Category $categoryRepository
     * @param Acme\User\UserRepository $userRepository
     * @param Acme\Photo\PhotoRepository $photoRepository
     * @param TagRepository $tagRepository
     */
    public function __construct(BlogRepository $blogRepository, CategoryRepository $categoryRepository, UserRepository $userRepository, PhotoRepository $photoRepository, TagRepository $tagRepository)
    {
        $this->blogRepository     = $blogRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository     = $userRepository;
        $this->photoRepository    = $photoRepository;
        $this->beforeFilter('Admin');
        parent::__construct();
        $this->tagRepository = $tagRepository;
    }

    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function index()
    {
        // Title
        $title = Lang::get('admin.blogs.title.blog_management');
        // Grab all the blog posts
        $posts = $this->blogRepository->getAll();
        // Show the page
        $this->render('admin.blogs.index', compact('posts', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Title
        $category = $this->select + $this->categoryRepository->getPostCategories()->lists('name_ar', 'id');
        $author   = $this->select + $this->userRepository->getRoleByName('author')->lists('username', 'id');
        $title    = Lang::get('admin.blogs.title.create_a_new_blog');
        $tags     = [''=>''] + $this->tagRepository->getList('name_ar','id');
        // Show the page
        $this->render('admin.blogs.create', compact('title', 'category', 'author','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $val = $this->blogRepository->getCreateForm();

        if ( ! $val->isValid() ) {
            return Redirect::back()->withInput()->withErrors($val->getErrors());
        }

        if ( ! $record = $this->blogRepository->create($val->getInputData()) ) {
            return Redirect::back()->with('errors', $this->blogRepository->errors())->withInput();
        }

        $tags = is_array(Input::get('tags')) ? array_filter(Input::get('tags')) : [];
        $this->tagRepository->attachTags($record, $tags);

        return Redirect::action('AdminPhotosController@create', ['imageable_type' => 'Blog', 'imageable_id' => $record->id]);

    }

    /**
     * Display the specified resource.
     * @param $id
     * @internal param $post
     * @return Response
     */
    public function show($id)
    {
        // redirect to the frontend
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @internal param $post
     * @return Response
     */
    public function edit($id)
    {
        $title    = Lang::get('admin.blogs.title.blog_update');
        $category = $this->select +  $this->categoryRepository->getPostCategories()->lists('name_ar', 'id');
        $author   = $this->select + $this->userRepository->getRoleByName('author')->lists('username', 'id');
        $post     = $this->blogRepository->findById($id);

        $tags       = $this->tagRepository->getList('name_ar','id');
        $dbTags =     $post->tags->lists('id');
        // Show the page
        $this->render('admin.blogs.edit', compact('post', 'title', 'category', 'author','tags','dbTags'));
    }

    /**
     * Update the specified resource in storage.
     * @param $id
     * @internal param $post
     * @return Response
     */
    public function update($id)
    {
        $record = $this->blogRepository->findById($id);

        $val = $this->blogRepository->getEditForm($id);

        if ( ! $val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( ! $this->blogRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->blogRepository->errors())->withInput();
        }

        $tags = is_array(Input::get('tags')) ? array_filter(Input::get('tags')) : [];
        $this->tagRepository->attachTags($record, $tags);

        return Redirect::action('AdminBlogsController@edit', $id)->with('success', 'Updated');
    }


    public function delete($id)
    {
        $post = $this->blogRepository->find($id);
        // Title
        $title = Lang::get('admin.blogs.title.blog_delete');

        // Show the page
        $this->render('admin.blogs.delete', compact('post', 'title'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @internal param $post
     * @return Response
     */
    public function getDelete($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @internal param $post
     * @return Response
     */

    public function destroy($id)
    {
        if ($this->blogRepository->findById($id)->delete()) {

            return Redirect::action('AdminBlogsController@index')->with('success','Deleted');
        }
        return Redirect::action('AdminBlogsController@index')->with('error','Could not Delete');

    }

}