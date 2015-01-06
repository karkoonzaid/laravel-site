@extends('admin.master')


@section('content')
<h1>Add Photos </h1>
{{ Form::open(array('method' => 'POST', 'action' => array('AdminPhotosController@store'), 'files'=> true)) }}

{{ Form::hidden('imageable_type', $imageableType ) }}
{{ Form::hidden('imageable_id', $imageableId ) }}

<div class="fallback">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('file', 'Upload Images:') }}
            {{ Form::file('name',NULL,array('class'=>'form-control')) }}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
        </div>
    </div>
</div>

{{ Form::close() }}

@stop