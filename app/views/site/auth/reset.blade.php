@extends('site.layouts._two_column')
@section('content')
<div class="page-header">
	<h1>{{ trans('auth.reset.heading') }}</h1>
</div>

{{ Form::open(['action' => 'AuthController@postReset', 'method' => 'post']) }}
    {{ Form::hidden('token',Input::get('token',$token)) }}
    <div class="form-group">
        <label for="email">{{{ trans('word.email') }}}</label>
        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('word.email') ]) }}
    </div>
    <div class="form-group">
        <label for="password">{{{ trans('word.password') }}}</label>
        {{ Form::password('password', ['class' => 'form-control', 'placeholder' =>trans('word.password') ]) }}
    </div>
    <div class="form-group">
        <label for="password_confirmation">{{{ trans('word.password_confirmation') }}}</label>
        {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' =>trans('word.password_confirmation') ]) }}
    </div>

    <div class="form-actions form-group">
        <button type="submit" class="btn btn-success">{{{ trans('auth.forgot.submit') }}}</button>
    </div>
{{ Form::close() }}
@stop
