<?php

use Acme\Comment\CommentRepository;

class AdminCommentsController extends AdminBaseController {

    /**
     * Comment Model
     * @var Comment
     */
    protected $commentRepository;

    /**
     * Inject the models.
     * @param Acme\Comment\CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->beforeFilter('Admin');
        $this->commentRepository = $commentRepository;
        parent::__construct();
    }

    /**
     * Show a list of all the comment posts.
     *
     * @return View
     */
    public function index()
    {
        // Grab all the comment posts
        $comments = $this->commentRepository->getAll();

        // Show the page
        $this->render('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @internal param $comment
     * @return Response
     */
    public function edit($id)
    {
        $comment = $this->commentRepository->findById($id);
        $this->render('admin.comments.edit', compact('comment'));
    }

    public function update($id)
    {
        $this->commentRepository->findById($id);

        $val = $this->commentRepository->getEditForm($id);

        if ( ! $val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( ! $this->commentRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->commentRepository->errors())->withInput();
        }

        return Redirect::action('AdminCommentsController@index')->with('success', 'Updated');
    }


    public function destroy($id)
    {
        $this->commentRepository->findById($id)->delete();

        return Redirect::action('AdminCommentsController@index');
    }

}
