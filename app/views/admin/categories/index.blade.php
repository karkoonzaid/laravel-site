@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>All Categories</h1>

<p>{{ link_to_action('AdminCategoriesController@create', 'Add new category') }}</p>

@if ($categories->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Type</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($categories as $category)
				<tr>
					<td>{{ $category->name }}</td>
					<td>
                        @if($category->type == 'EventModel')
                        Event
                        @elseif($category->type == 'Post')
                        Blog
                        @endif

					</td>
                    <td><a href="{{ URL::action('AdminCategoriesController@edit',  array($category->id), array('class' => 'btn btn-info')) }}">Edit</a></td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminCategoriesController@destroy', $category->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no categories
@endif

@stop
