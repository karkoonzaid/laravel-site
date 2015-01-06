<div class="panel panel-default">
    <div class="panel-heading">{{ trans('word.category') }}</div>
    <div class="panel-body">
        <ul>
            @if($categories)
            @foreach($categories as $category)
            <li class="unstyled"><i class="fa fa-book"></i><a href="{{URL::action('CategoriesController@getPosts',$category->id)}}"> {{ $category->name }}</a></li>
            @endforeach
            @endif
        </ul>
    </div>
</div>