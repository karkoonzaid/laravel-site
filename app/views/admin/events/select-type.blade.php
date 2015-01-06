@extends('admin.master')

@section('style')
@parent

@stop

{{-- Content --}}
@section('content')
@include('admin.events.breadcrumb' ,array('active'=>'type'))
<div class="row setup-content" id="step-1">
    <div class="col-xs-12">
        <div class="col-md-12 well text-center">
            <div class="ui-group-buttons">
                <a href="{{ action('AdminEventsController@create') }}" class="btn  btn-success" role="button"><span class="fa fa-calendar"></span> Event</a>
                <div class="or"></div>
                <a href="{{ action('AdminPackagesController@create') }}" class="btn btn-success" role="button"><span class="fa fa-database"></span> Package</a>
            </div>
        </div>
    </div>
</div>

@stop
