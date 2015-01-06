@extends('admin.master')

{{-- Content --}}
@section('content')
<h1>Event Details</h1>
<p>{{ link_to_action('AdminEventsController@create', 'Add new event') }}</p>

@if ($event)
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
                <td>Event Id</td>
				<th>Title</th>
				<th>Author</th>
				<th>Start Date</th>
				<th>End Date</th>
                <th>Posted</th>
                <th>Event Information</th>
			</tr>
		</thead>

		<tbody>
        <tr>
            <td>{{{ $event->id }}}</td>
            <td>{{{ $event->title }}}</td>
            <td>{{{ $event->user->username }}}</td>
            <td>{{{ $event->date_start }}}</td>
            <td>{{{ $event->date_end }}}</td>
            <td>{{{ $event->getHumanCreatedAtAttribute() }}} </td>
            <td>
                <div class="btn-group btn-group-sm">
                    <a href="{{action('AdminEventsController@getFollowers',$event->id) }}" class="btn btn-default">{{ $followers_count }} - Followers</a>
                    <a href="{{action('AdminEventsController@getSubscriptions',$event->id) }}" class="btn btn-default">{{ $subscriptions_count }} - Subscriptions</a>
                    <a href="{{action('AdminEventsController@getFavorites',$event->id) }}" class="btn btn-default">{{ $favorites_count }} - Favorites</a>
                    <a href="{{action('AdminEventsController@getRequests',$event->id) }}" class="btn btn-default">{{ $requests_count }} - Reorganize Requests</a>
                </div>
            </td>

        </tr>

		</tbody>
	</table>
@else
	There are no events
@endif

@stop
