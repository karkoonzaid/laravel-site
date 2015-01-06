@extends('site.layouts._two_column')
@section('content')

<div class="page-header">
    <h1>{{ trans('auth.forgot.title') }}</h1>
</div>

{{ Form::open(['action'=>['AuthController@postForgot'],'method'=>'POST']) }}
    <div class="form-group">
        <label for="email">{{{ trans('word.email') }}}</label>
        <div class="input-append input-group">
            {{ Form::text('email',null,['class'=>'form-control', 'placeholder'=> trans('word.email')]) }}

            <span class="input-group-btn">
                <input class="btn btn-primary" type="submit" value="{{{ trans('word.submit') }}}">
            </span>
        </div>
    </div>

{{ Form::close() }}

@stop
