@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>All Tags</h1>

<p>{{ link_to_action('AdminTagsController@create', 'Add New Tag') }}</p>

@if ($tags->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($tags as $tag)
				<tr>
					<td>{{{ $tag->name }}}</td>
                    <td>{{ link_to_action('AdminTagsController@edit', 'Edit', array($tag->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminTagsController@destroy', $tag->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no Tags
@endif

@stop
