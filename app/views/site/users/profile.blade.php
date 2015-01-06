@extends('site.layouts._one_column')

@section('style')
    @parent
    <style>
        .panel-primary {
            border-color: rgba(232, 241, 242, 1);
            border-top:none;
        }
        .panel > .list-group {
            margin: 10px;
            border:#cccccc 1px ;
        }
    </style>
@stop

@section('content')

    <div class="col-md-12">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#profile" data-toggle="tab">{{ trans('word.profile') }}</a></li>

            @if($user->isOwner())
                <li><a href="#favorites" data-toggle="tab">{{ trans('word.favorites') }}</a></li>
                <li><a href="#subscriptions" data-toggle="tab">{{ trans('word.subscriptions') }}</a></li>
                <li><a href="#followings" data-toggle="tab">{{ trans('word.followings') }}</a></li>
            @endif

        </ul>

        <div class="tab-content">

            <div class="tab-pane active" id="profile">
                <h1>{{ trans('word.profile') }}</h1>

                <div class="col-lg-3">
                    <img class="img-circle" src="" alt=""><span class="fa-5"><i class="fa fa-user"></i></span>
                    <h2><a href="{{ action('UserController@edit',$user->id)}}"><i class="fa fa-edit"></i>&nbsp;&nbsp;  {{ trans('word.edit') }}</a></h2>
                </div>

                <div class="col-lg-8">
                    @include('site.users._detail')
                </div>

            </div>
            @if($user->isOwner())
                <div class="tab-pane" id="favorites">
                    <div class="panel panel-primary">
                        <ul class="list-group">
                            @foreach($user->favorites as $event)
                                @include('site.events._results')
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-pane" id="subscriptions">
                    <div class="panel panel-primary">
                        <ul class="list-group">
                            @foreach($user->subscriptions as $event)
                                @include('site.events._results')
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-pane" id="followings">
                    <div class="panel panel-primary">
                        <ul class="list-group">
                            @foreach($user->followings as $event)
                                @include('site.events._results')
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script>
        $(function () {
            $('#myTab a:last').tab('show')
        })
    </script>
@stop
