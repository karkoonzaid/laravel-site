@extends('site.layouts._two_column')

    @section('sidebar')
        <div class="panel panel-default">
            <div class="panel-heading">{{ trans('word.category') }}</div>
            <div class="panel-body">
                <ul>
                    @if($categories)
                        @foreach($categories as $category)
                            <li class="unstyled"><i class="glyphicon glyphicon-tag"></i><a href="{{URL::action('CategoriesController@getEvents',$category->id)}}"> {{ $category->name }}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    @parent
    @stop

@section('content')
    <style>
        .padded {
            padding: 0;
            margin: 0 5px 0 5px;
        }
    </style>

    @if(count($events))
        @foreach($events as $event)
            <div class="row top20">
                <div class="col-sm-2 col-md-2 ">
                    <div id="links">
                        @if(count($event->photos))
                            <a href="{{ action('EventsController@show',$event->id) }}">
                                {{ HTML::image('uploads/thumbnail/'.$event->photos[0]->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }}
                            </a>
                        @else
                            <a href="{{ action('EventsController@show',$event->id) }}">
                                <img src="http://placehold.it/70x70" class="img-thumbnail">
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-sm-10 col-md-10">
                    <span class="event-title">
                        <a href="{{action('EventsController@show',$event->id )}}">
                            {{ $event->title }}
                        </a>
                    </span>
                    <p>
                        {{ Str::limit($event->description, 150) }}
                        <a href="{{action('EventsController@show',$event->id )}}">{{ trans('word.more')}}</a>
                    </p>

                </div>
            </div>

            <div class="row" style="margin: 9px; ">

                <i class="glyphicon glyphicon-user">
                    {{ link_to_action('EventsController@index', $event->user->username,array('search'=>'','author'=>$event->user->id)) }}
                |</i>
                <i class="glyphicon glyphicon-calendar"></i> {{ $event->date_start }} -  {{ $event->date_end }} |

                    @if($event->location)
                        @if($event->location->country)
                            <i class="glyphicon glyphicon-globe">
                                    {{ link_to_action('EventsController@index', $event->location->country->name ,array('search'=>'','country'=>$event->location->country->id)) }}
                            |</i>

                            <i class="glyphicon glyphicon-tag"></i>&nbsp;&nbsp;
                        @endif
                    @endif
                    @if($event->category)
                        {{ link_to_action('EventsController@index', $event->category->name,array('search'=>'','category'=>$event->category->id)) }}
                    @endif
            </div>
            <hr>
        @endforeach
        {{ $events->appends(Request::except('page'))->links() }}
    @else
        <h1> {{ trans('word.no_results') }} </h1>
    @endif
@stop
