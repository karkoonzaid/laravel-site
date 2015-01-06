@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>Edit Country</h1>
{{ Form::model($tag, array('method' => 'PATCH', 'action' => array('AdminTagsController@update', $tag->id))) }}

<div class="form-group">
    {{ Form::label('arabic_name', 'Arabic Name:') }}
    {{ Form::text('name_ar', NULL,array('class'=>'form-control')) }}
</div>
<div class="form-group">
    {{ Form::label('english_name', 'English Name:') }}
    {{ Form::text('name_en', NULL,array('class'=>'form-control')) }}
</div>

{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
{{ link_to_action('AdminCountriesController@show', 'Cancel', $tag->id, array('class' => 'btn')) }}
<!-- ./ form actions -->
{{ Form::close() }}


{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
