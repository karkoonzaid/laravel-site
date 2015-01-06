@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>Show Country</h1>

<p>{{ link_to_action('AdminCountriesController@index', 'Return to all countries') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $country->name }}}</td>
                    <td>{{ link_to_action('AdminCountriesController@edit', 'Edit', array($country->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminCountriesController@destroy', $country->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
