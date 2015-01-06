@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>Update Contact-Us Details</h1>

{{ Form::model($contact,array('method' => 'POST','action' => array('AdminContactsController@store'))) }}
    <div class="form-group">
        {{ Form::label('name_en', 'Name in English:',array('class'=>'control-label')) }}
        {{ Form::text('name_en',NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('name_ar', 'Name in Arabic:',array('class'=>'control-label')) }}
        {{ Form::text('name_ar',NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('address_en', 'Company Address in English:',array('class'=>'control-label')) }}
        {{ Form::textarea('address_en',NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('address_ar', 'Company Address in Arabic:',array('class'=>'control-label')) }}
        {{ Form::textarea('address_ar',NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('email', 'Company Email:',array('class'=>'control-label')) }}
        {{ Form::text('email',NULL,array('class'=>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('phone', 'Company Phone:',array('class'=>'control-label')) }}
        {{ Form::text('phone',NULL,array('class'=>'form-control')) }}
    </div>
<div class="form-group">
        {{ Form::label('mobile', 'Mobile Phone:',array('class'=>'control-label')) }}
        {{ Form::text('mobile',NULL,array('class'=>'form-control')) }}
    </div>

        <div class="form-group">
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
        </div>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


