<div id="side-1">
    <div class="panel panel-default">
        <div class="panel-heading"> {{ trans('word.latest_events') }} </div>
        <div class="panel-body">
            <ul>
                @if($latest_event_posts)
                    @foreach($latest_event_posts as $event)
                        <li class="unstyled"><i class="fa fa-bullhorn"></i> <a href="{{URL::action('EventsController@show',$event->id)}}"> {{ $event->title }}</a></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
