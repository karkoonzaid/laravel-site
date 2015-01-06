@extends('admin.master')

{{-- Content --}}
@section('content')


<h1>Create Location</h1>
<!--<form class="form-horizontal" method="post" action="{{ URL::to('country/create') }}" autocomplete="off">-->
{{ Form::open(array('action' => 'AdminLocationsController@store')) }}
<!-- CSRF Token -->

<div class="form-group">
    {{ Form::label('arabic_name', 'Arabic Name:') }}
    {{ Form::text('name_ar', NULL,array('class'=>'form-control')) }}
</div>
<div class="form-group">
    {{ Form::label('english_name', 'English Name:') }}
    {{ Form::text('name_en', NULL,array('class'=>'form-control')) }}
</div>
    <div class="form-group">
        {{ Form::label('country_id', 'Country:') }}
        {{ Form::select('country_id', $countries,NULL,array('class'=>'form-control')) }}
    </div>

        {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}

<!-- ./ form actions -->
</form>

@if ($errors->any())
<ul>
    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
</ul>
@endif

@stop


