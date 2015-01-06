@extends('admin.master')

{{-- Content --}}
@section('content')

    {{ Form::model($setting, array('method' => 'post', 'action' => array('AdminSettingsController@postAddRoom',$setting->id), 'role'=>'form')) }}

        <div class="row">

        <div class="row">
            <div class="form-group col-md-12">
                {{ Form::label('online_room_id', 'Input the Online Room Number:') }}
                {{ Form::text('online_room_id',null,['class'=>'form-control'])}}
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                {{ Form::submit('Save', array('class' => 'btn btn-info')) }}
            </div>
        </div>

    {{ Form::close() }}

    @if ($errors->any())
        <div class="row">
            <div class="alert alert-danger">
                <ul>
                    {{ implode('', $errors->all('<li class="error"> - :message</li>')) }}
                </ul>
            </div>
        </div>
    @endif

@stop


