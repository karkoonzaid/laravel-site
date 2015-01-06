@extends('site.layouts._two_column')

@section('content')
    @if(count($events))
        <h1> {{ trans('word.suggested_events') }}</h1>
        @foreach($events as $event)
            @include('site.events._results')
        @endforeach
    @endif
@stop
