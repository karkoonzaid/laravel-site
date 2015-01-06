@extends('site.layouts._two_column')

@section('login')
@stop

@section('content')

<div class="page-header">

        @if(Session::has('account_not_active'))
            {{ Form::open(['action'=>'AuthController@sendActivationLink','method'=>'post']) }}
                {{ Form::hidden('user_id',Session::get('user.id')) }}
                {{ Form::submit(trans('auth.alerts.resent_activation_link'), array('class' => 'btn btn-lg btn-success')) }}
            {{ Form::close() }}
        @endif

    <h1>{{ trans('auth.login.heading')}}</h1>
</div>
{{ Form::open(['action' => 'AuthController@postLogin', 'method' => 'post']) }}
    <div class="col-md-12">

        <div class="form-group">
            <label>{{ trans('word.email') }}</label>

            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('word.email') ]) }}
            </div>
        </div>

        <div class="form-group">
            <label>{{ trans('word.password')  }}</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => trans('word.password') ]) }}
            </div>
        </div>


        <div class="form-group">
            <div class="checkbox">
                <label class="checkbox">
                    {{ Form::checkbox('remember', '1', true,  ['id' => 'remember']) }}
                    {{ trans('word.remember') }}
                </label>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{ trans('auth.login.submit') }}</button>
            <a class="btn btn-default" href="forgot">{{ trans('word.forgot_password') }}</a>
            <a href="{{ action('AuthController@getSignup') }}" type="submit" class="btn btn-default">{{ trans('word.register') }}</a>
        </div>

    </div>

    {{ Form::close() }}

@stop
