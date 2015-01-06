<div class="panel panel-default">
    <div class="panel-heading">{{ trans('word.category') }}</div>
    <div class="panel-body">
        <ul>
            @if($eventCategories)
                @foreach($eventCategories as $eventCategory)
                    <li class="unstyled"><i class="fa fa-book"></i><a href="{{action('CategoriesController@getEvents',$eventCategory->id)}}"> {{ $eventCategory->name }}</a></li>
                @endforeach
            @endif
        </ul>
    </div>
</div>