@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>Show Tag</h1>

<p>{{ link_to_action('AdminTagsController@index', 'Return to all countries') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $tag->name }}}</td>
            <td>{{ link_to_action('AdminTagsController@edit', 'Edit', array($tag->id), array('class' => 'btn btn-info')) }}</td>
            <td>
                {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminTagsController@destroy', $tag->id))) }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
            </td>
		</tr>
	</tbody>
</table>

@stop
