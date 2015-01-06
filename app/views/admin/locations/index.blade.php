@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>All Locations</h1>

<p>{{ link_to_action('AdminLocationsController@create', 'Add new location') }}</p>

@if ($locations->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Country</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($locations as $location)
				<tr>
					<td>{{{ $location->name }}}</td>
					<td>{{{ $location->country ? $location->country->name : '' }}}</td>
                    <td>{{ link_to_action('AdminLocationsController@edit', 'Edit', array($location->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminLocationsController@destroy', $location->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no locations
@endif

@stop
