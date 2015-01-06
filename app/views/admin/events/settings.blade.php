@extends('admin.master')

{{-- Content --}}
@section('content')
<h1>Events</h1>
<p>{{ link_to_action('AdminEventsController@create', 'Add new event') }}</p>

@if ($event)

@else
	There are no events
@endif

@stop
