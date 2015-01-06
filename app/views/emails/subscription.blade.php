@extends('emails.layouts.default')
@section('body')
    <div class="right" style="float: right; text-align:right;">
        <h1 style="float: right; text-align:right;"> {{ trans('word.hello') }}, {{ $name_ar }}</h1>
        <br>
        <p style="float: right; text-align:right;">{{ $body }}</p>
    </div>
@stop