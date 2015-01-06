@extends('admin.master')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop

{{-- Content --}}
@section('content')

<div class="page-header">
    <h3>
         Manage Users

        <div class="pull-right">
            <a href="{{{ URL::to('admin/users/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
        </div>
    </h3>
</div>
<div id="wrap">
    <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered">
        <thead>
        <tr>
            <th class="col-md-2">Name in AR</th>
            <th class="col-md-2">Name in EN</th>
            <th class="col-md-2">Email</th>
            <th class="col-md-2">Mobile</th>
            <th class="col-md-2">Country</th>
            <th class="col-md-2">Role</th>
            <th class="col-md-2">Active</th>
            <th class="col-md-2">Action</th>
			</tr>
		</thead>
        <tbody>
        @foreach($users as $user)
        <tr class="gradeX">
            <td><a href="{{ action('AdminUsersController@show',$user->id) }}">{{ $user->name_ar }}</a></td>
            <td>{{ $user->name_en }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->mobile }}</td>
            <td>{{ $user->country }}</td>
            <td>
                <?php $roles=[]; ?>
                @foreach ( $user->roles as $role )
                    <?php $roles[] = $role->name; ?>
                @endforeach
                {{ implode(',',$roles) }}
            </td>
            <td>{{ $user->active == 1 ? 'true':'false' }}</td>
            <td>

                <a href="{{  URL::action('AdminUsersController@printDetail',$user->id ) }}" class=" btn btn-xs btn-default"><i class="glyphicon glyphicon-print"></i> Print</a>
                <a href="{{  URL::action('AdminUsersController@edit',$user->id ) }}" class=" btn btn-xs btn-default">Edit</a>
                {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminUsersController@destroy', $user->id))) }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-xs btn-danger')) }}
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
		</tbody>
	</table>
</div>
<div class="row">
    <div class="col-md-12">
       <?php echo $users->appends(Request::except('page'))->links(); ?>
    </div>
</div>
@stop