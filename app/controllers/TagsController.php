<?php

use Acme\Tag\TagRepository;

class TagsController extends BaseController {


    // Dependent Injection Patter - object of EventModel
    /**
     * @var TagRepository
     */
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
        parent::__construct();
    }

    public function getEvents($id)
    {
        $tag    = $this->tagRepository->findById($id);
        $tags = $this->tagRepository->getEventTags();
        $events = $tag->events()->paginate(5);
        $this->title = $tag->name;
        $this->render('site.tags.events', compact('events', 'tag','tags'));
    }

    public function getBlogs($id)
    {
        $tag    = $this->tagRepository->findById($id);
        $tags = $this->tagRepository->getBlogTags();
        $posts = $tag->blogs()->paginate(5);

        $this->title = $tag->name;
        $this->render('site.tags.blogs', compact('posts', 'tag','tags'));
    }

}