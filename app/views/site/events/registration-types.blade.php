<!-- Extends From Two Column Layou -->
@extends('site.layouts._one_column')

<!-- Content Section -->
@section('content')
    @parent
    <style>
        .panel-body {
            background-color: white !important;
            border-radius: 0px !important;
            background-image: none;
        }

        .panel-heading {
            border: none !important;
            background-color: transparent;

        }

        .parent_panel > .panel-body {
            border: 4px solid #462878;
        }

        .parent_panel > .panel-heading {
            width: 167%;
            border: none;
        }

        .separator {
            border: 1px solid #462878;
        }

        .lower-panel {
            background-color: #462878;
            padding: 15px;
        }
    </style>

    @if($vip)
        <div class="col-md-4">
            <div class="panel panel-default parent_panel">
                <div class="panel-heading">
                    {{ strtoupper(trans('word.vip'))  }}
                </div>
                <div class="panel-body">

                    @if(!$freeEvent)
                        <div class="col-md-12">
                            <div class="form-group">
                                <p>
                                    <span class="mute"> {{ $setting->vip_description }}</span>
                                <hr class="separator">
                                </p>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <p>

                            <h3 class="text-center"> {{ $event->isFreeEvent() ? trans('word.free_event') : trans('word.price') . ' ' . $price['vip'] . ' ' .$country->currency }} </h3></p>
                        </div>
                    @endif

                    <span class="col-md-12 lower-panel">
                        {{ Form::open(['action' => 'SubscriptionsController@subscribe', 'method' => 'post'], ['class'=>'form']) }}
                        {{ Form::hidden('event_id',$event->id) }}
                        {{ Form::hidden('registration_type','VIP') }}
                        {{ Form::submit( trans('word.subscribe') , ['class'=>'btn btn-default btn-block']) }}
                        {{ Form::close() }}
                    </span>

                </div>
            </div>

        </div>
    @endif

    @if($online)
        <div class="col-md-4">
            <div class="panel panel-default parent_panel">
                <div class="panel-heading">
                    {{ strtoupper(trans('word.online'))  }}
                </div>
                <div class="panel-body">

                    @if(!$freeEvent)
                        <div class="col-md-12">
                            <div class="form-group">
                                <p>
                                    <span class="mute"> {{ $setting->online_description }}</span>
                                <hr class="separator">
                                </p>
                                <!-- show for only package subscription view -->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <p>

                            <h3 class="text-center">{{ $event->isFreeEvent() ? trans('word.free_event') : trans('word.price') . ' ' . $price['online'] . ' ' .$country->currency }} </h3></p>
                        </div>
                    @endif

                    <span class="col-md-12 lower-panel">
                        {{ Form::open(['action' => 'SubscriptionsController@subscribe', 'method' => 'post'], ['class'=>'form']) }}
                        {{ Form::hidden('event_id',$event->id) }}
                        {{ Form::hidden('registration_type','ONLINE') }}
                        {{ Form::submit( trans('word.subscribe') , ['class'=>'btn btn-default btn-block']) }}
                        {{ Form::close() }}
                    </span>

                </div>
            </div>

        </div>


    @endif

    @if($normal)
        <!-- Normal -->
        <div class="col-md-4">
            <div class="panel panel-default parent_panel">
                <div class="panel-heading">
                    {{ strtoupper(trans('word.normal'))  }}
                </div>
                <div class="panel-body">

                    @if(!$freeEvent)

                        <div class="col-md-12">
                            <div class="form-group">
                                <p>
                                    <span class="mute"> {{ $setting->normal_description }} </span>
                                <hr class="separator">
                                </p>
                                <!-- show for only package subscription view -->
                            </div>
                        </div>

                        <div class="col-md-12">

                            <p>

                            <h3 class="text-center">{{ $event->isFreeEvent() ? trans('word.free_event') : trans('word.price') . ' ' . $price['normal']. ' ' .$country->currency }} </h3></p>
                        </div>

                    @endif

                    <span class="col-md-12 lower-panel">
                        {{ Form::open(['action' => 'SubscriptionsController@subscribe', 'method' => 'post'], ['class'=>'form']) }}
                        {{ Form::hidden('event_id',$event->id) }}
                        {{ Form::hidden('registration_type','NORMAL') }}
                        {{ Form::submit( trans('word.subscribe') , ['class'=>'btn btn-default btn-block']) }}
                        {{ Form::close() }}
                     </span>

                </div>
            </div>

        </div>

    @endif

@stop