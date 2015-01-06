<!-- Extends From Two Column Layou -->
@extends('site.layouts._two_column')

@section('sidebar')
    @include('site.events._tags')
    @parent
@stop
@section('content')

    @foreach($events as $event)
        @include('site.events._results')
    @endforeach

@stop