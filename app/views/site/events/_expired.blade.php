<div class="panel panel-default">
    <div class="panel-heading">{{ trans('word.expired_events') }}</div>
    <div class="panel-body">
        <ul>
            @if($expiredEvents)
                @foreach($expiredEvents as $event)
                    <li class="unstyled"><i class="glyphicon glyphicon-calendar"></i> <a href="{{URL::action('EventsController@show',$event->id)}}"> {{ $event->title }}</a></li>
                @endforeach
                <hr>
                <a href="{{action('EventsController@index',['past'=>'true'])}}">{{ trans('word.view_all_expired_events') }}</a>
            @endif
        </ul>
    </div>
</div>