@extends('admin.master')

{{-- Content --}}
@section('content')
	<div class="page-header">
		<h3>
			Role Management

			<div class="pull-right">
				<a href="{{{ URL::to('admin/roles/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
		</h3>
	</div>

	<table id="roles" class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="col-md-6">{{{ Lang::get('admin/roles/table.name') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/roles/table.users') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/roles/table.created_at') }}}</th>
				<th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($roles as $role)
        				<tr>
        					<td>{{{ $role->name }}}</td>
                            <td>{{ link_to_action('AdminRolesController@edit', 'Edit', array($role->id), array('class' => 'btn btn-info')) }}</td>
                            <td>
                                {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminRolesController@destroy', $role->id))) }}
                                    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                                {{ Form::close() }}
                            </td>
        				</tr>
        			@endforeach
		</tbody>
	</table>
@stop