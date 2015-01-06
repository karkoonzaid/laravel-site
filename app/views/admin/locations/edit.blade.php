@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>Edit Location</h1>
{{ Form::model($location, array('method' => 'PATCH', 'action' => array ('AdminLocationsController@update', $location->id))) }}
    <div class="form-group">
        {{ Form::label('arabic_name', 'Arabic Name:') }}
        {{ Form::text('name_ar', NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('english_name', 'English Name:') }}
        {{ Form::text('name_en', NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('country_id', 'Country_id:',array('class'=>'control-label')) }}
        {{ Form::select('country_id', $countries,NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
        {{ link_to_action('AdminLocationsController@show', 'Cancel', $location->id, array('class' => 'btn')) }}
    </div>

{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
