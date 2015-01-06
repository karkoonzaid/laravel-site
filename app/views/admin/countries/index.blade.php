@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>All Countries</h1>

<p>{{ link_to_action('AdminCountriesController@create', 'Add new country') }}</p>

@if ($countries->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>ISO Code</th>
				<th>Currency</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($countries as $country)
				<tr>
					<td>{{{ $country->name }}}</td>
					<td>{{{ $country->iso_code }}}</td>
					<td>{{{ $country->currency }}}</td>
                    <td>{{ link_to_action('AdminCountriesController@edit', 'Edit', array($country->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminCountriesController@destroy', $country->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no countries
@endif

@stop
