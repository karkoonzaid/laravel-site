@extends('emails.layouts.default')
@section('body')
    <h2 style="text-align: right">{{trans('auth.reset.title')}}</h2>
    <div style="text-align: right">
        {{trans('auth.reset.body')}} <a href="{{ URL::to('password/reset',array($token)) }}">{{ URL::to('password/reset', array($token)) }}</a>.
    </div>
@stop