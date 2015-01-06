@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>Category</h1>

<p>{{ link_to_action('AdminCategoriesController@index', 'Return to all Categories') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{ $category->name }}</td>
            <td>
                {{ link_to_action('AdminCategoriesController@edit', 'Edit', array($category->id), array('class' => 'btn btn-xs btn-info')) }}
            </td>
            <td>
                {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminCategoriesController@destroy', $category->id))) }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-xs btn-danger')) }}
                {{ Form::close() }}
            </td>
		</tr>
	</tbody>
</table>

@stop
