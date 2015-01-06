@extends('admin.master')

{{-- Content --}}
@section('content')
    <table class="table table-striped table-bordered">
		<thead>
			<tr>
                <th class="col-md-3">{{{ Lang::get('admin/comments/table.title') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/comments/table.created_at') }}}</th>
				<th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
			</tr>
		</thead>
        <tbody>
            @foreach($comments as $comment)
            <tr>
                <td>{{ $comment->content }}</td>
                <td>{{ $comment->created_at }}</td>
                <td>{{ link_to_action('AdminCommentsController@edit', 'Edit', array($comment->id), array('class' => 'btn btn-info')) }}</td>
                <td>
                    {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminCommentsController@destroy', $comment->id))) }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                    {{ Form::close() }}
                </td>
            </tr>
            @endforeach
        </tbody>
	</table>
@stop
