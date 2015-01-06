@extends('emails.layouts.default')
@section('body')
    <h2 style="text-align: right">{{trans('word.welcome_to_kaizen')}}  </h2>
    <div style="text-align: right">
        {{ $body }}
    </div>
@stop