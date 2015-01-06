@extends('admin.master')

{{-- Web site Title --}}
@section('title')
Blog Post
@stop

{{-- Content --}}
@section('content')
	<div class="page-header">
		<h3>
			Ads

			<div class="pull-right">
				<a href="{{ URL::action('AdminAdsController@create') }}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
		</h3>
	</div>

    <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered">
        <thead>
			<tr>
				<th class="col-md-4">Ad Title</th>
				<th class="col-md-4">Update Photos</th>
				<th class="col-md-2">Updated on</th>
				<th class="col-md-2">Active</th>
				<th class="col-md-2">Actions</th>
			</tr>
		</thead>
		<tbody>
            @foreach($ads as $ad)
            <tr>
                <td>{{ $ad->title }}</td>
                <td><a href="{{ URL::action('AdminPhotosController@createNormal', ['imageable_type' => 'Ad', 'imageable_id' => $ad->id]) }}" class="btn btn-xs btn-success">Update Photo</a></td>
                <td>{{ $ad->updated_at }}</td>
                <td>
                    {{ Form::open(array('method' => 'POST', 'action' => array('AdminAdsController@updateActive', $ad->id))) }}
                        @if($ad->active)
                            {{ Form::checkbox('active', 1, 'checked')  }}
                        @else
                            {{ Form::checkbox('active', 1, false)  }}
                        @endif
                        {{ Form::submit('Update Active', array('class' => 'btn btn-xs btn-success')) }}
                    {{ Form::close() }}
                </td>
                <td><a href="{{ URL::action('AdminAdsController@edit', array($ad->id)) }}" class="btn btn-success btn-xs">Edit</a></td>
                <td>
                    {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminAdsController@destroy', $ad->id))) }}
                        {{ Form::submit('Delete', array('class' => 'btn btn-xs btn-danger')) }}
                    {{ Form::close() }}
                </td>
            </tr>
            @endforeach
		</tbody>
	</table>
@stop