<div class="panel panel-default">
    <div class="panel-heading">{{ trans('word.tags') }}</div>
    <div class="panel-body">
        <ul>
            @if($tags)
                @foreach($tags as $tag)
                    <li class="unstyled"><i class="glyphicon glyphicon-tag"></i><a href="{{action('TagsController@getEvents',$tag->id)}}"> {{ $tag->name }}</a></li>
                @endforeach
            @endif
        </ul>
    </div>
</div>