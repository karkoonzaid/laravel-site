@extends('admin.master')

@section('content')
    <h1>Edit Ad </h1>

    {{ Form::model($ad,array('method' => 'PATCH', 'action' => array('AdminAdsController@update',$ad->id), 'role'=>'form', 'files' => true)) }}
    <div class="row">

         <div class="col-md-6">
             <div class="form-group">
                 <label class="control-label" for="title">Ad Title in English</label>
                 {{ Form::text('title_en', null, ['class' => 'form-control']) }}
             </div>
         </div>

         <div class="col-md-6">
             <div class="form-group">
                 <label class="control-label" for="title">Ad Title in Arabic</label>
                 {{ Form::text('title_ar', null, ['class' => 'form-control right']) }}
             </div>
         </div>

         <div class="col-md-12">
             <div class="form-group">
                 <label class="control-label" for="title">Ad Link</label>
                 {{ Form::text('url', null, ['class' => 'form-control']) }}
             </div>
         </div>

         <div class="col-md-12">
             <div class="form-group">
                 <button type="submit" class="btn btn-success">Save</button>
             </div>
         </div>

     </div>

	{{ Form::close() }}

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped custab">
                <thead>
                <span class="btn btn-primary btn-xs"> Delete Photos </span>
                <tr>
                    <th>Image </th>
                    <th class="text-center">Action</th>
                </tr>
                @foreach($ad->photos as $photo)
                   <tr>
                       <td> {{ HTML::image('uploads/thumbnail/'.$photo->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }} </td>
                       <td>

                       {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminPhotosController@destroy', $photo->id))) }}
                       {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                       {{ Form::close() }}
                       </td>
                   </tr>

                @endforeach
            </table>
        </div>
    </div>


    @if ($errors->any())
    <div class="row">
        <div class="alert alert-danger">
            <ul>
                {{ implode('', $errors->all('<li class="error"> - :message</li>')) }}
            </ul>
        </div>
    </div>
    @endif
@stop
