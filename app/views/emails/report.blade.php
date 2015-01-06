@extends('emails.layouts.default')
@section('body')
    <h1>Hey Admin.  This is Report About User {{ $report_user_username }} ( {{ $report_user_email }} )</h1>

    <p> {{ $body }} </p>
@stop