@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>Create Tags</h1>
{{-- Edit Blog Form --}}
<!--<form class="form-horizontal" method="post" action="{{ URL::to('tag/create') }}" autocomplete="off">-->
    {{ Form::open(array('action' => 'AdminTagsController@store')) }}
    <!-- CSRF Token -->
    <div class="form-group">
        {{ Form::label('arabic_name', 'Arabic Name:') }}
        {{ Form::text('name_ar', NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('english_name', 'English Name:') }}
        {{ Form::text('name_en', NULL,array('class'=>'form-control')) }}
    </div>

    {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
    <!-- ./ form actions -->
    {{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


