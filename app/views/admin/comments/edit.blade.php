@extends('admin.master')

{{-- Content --}}
@section('content')

	{{-- Edit Blog Comment Form --}}
    {{ Form::model($comment, array('method' => 'PATCH', 'action' => array('AdminCommentsController@update', $comment->id))) }}
        <!-- Content -->
        <div class="form-group">
                {{ Form::textarea('content', NULL,array('class'=>'form-control')) }}
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Update</button>
        </div>
		<!-- ./ form actions -->
	</form>
@stop