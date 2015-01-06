<div id="side-2">
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('word.latest_blog') }}</div>
        <div class="panel-body">
            <ul>
                @if($latest_blog_posts)
                    @foreach($latest_blog_posts as $post)
                        <li class="unstyled"><i class="fa fa-book"></i><a href="{{URL::action('BlogsController@show',$post->id)}}"> {{ $post->title }}</a></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>