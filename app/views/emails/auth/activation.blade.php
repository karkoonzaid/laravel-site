@extends('emails.layouts.default')
@section('body')
    <h2>{{trans('word.welcome_to_kaizen')}} {{ $name }}, </h2>
    <div>
        {{ trans('auth.account_confirmation.body') }}
        <br>
        <a href="{{$link}}">{{ $link }}</a>
    </div>
@stop