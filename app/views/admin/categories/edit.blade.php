@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>Edit Category</h1>

{{ Form::model($category, array('method' => 'PATCH', 'role'=>'form', 'action' => array('AdminCategoriesController@update', $category->id))) }}
    <div class="form-group">
        {{ Form::label('arabic_name', 'Arabic Name:') }}
        {{ Form::text('name_ar', NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('english_name', 'English Name:') }}
        {{ Form::text('name_en', NULL,array('class'=>'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('type', 'Type:',array('class'=>'control-label')) }}
        {{ Form::text('type',NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
        {{ link_to_action('AdminCategoriesController@show', 'Cancel', $category->id, array('class' => 'btn')) }}
    </div>

{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
