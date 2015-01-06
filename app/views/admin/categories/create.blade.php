@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>Create Category</h1>

{{ Form::open(array('action' => 'AdminCategoriesController@store')) }}
    <div class="form-group">
        {{ Form::label('arabic_name', 'Arabic Name:') }}
        {{ Form::text('name_ar', NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('english_name', 'English Name:') }}
        {{ Form::text('name_en', NULL,array('class'=>'form-control')) }}
    </div>

        <div class="form-group">
            {{ Form::label('type', 'Type:') }}
            {{ Form::select('type',['EventModel' => 'Event','Post' => 'Blog'],NULL,array('class'=>'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        </div>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


