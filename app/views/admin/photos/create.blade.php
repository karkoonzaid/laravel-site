@extends('admin.master')

@section('style')
@parent
{{ HTML::style('assets/vendors/dropzone/css/dropzone.css') }}
@stop

@section('content')
<h1>Add Photos </h1>
{{ Form::open(array('method' => 'POST', 'action' => array('AdminPhotosController@store'), 'class'=>'dropzone', 'id'=>'my-dropzone',  'files'=> true)) }}

{{ Form::hidden('imageable_type', $imageableType ) }}
{{ Form::hidden('imageable_id', $imageableId ) }}

<div class="fallback">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('file', 'Upload Images:') }}
            {{ Form::file('name',NULL,array('class'=>'form-control')) }}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
        </div>
    </div>
</div>

{{ Form::close() }}

@stop

@section('script')
@parent
{{ HTML::script('assets/vendors/dropzone/dropzone.min.js') }}

<script >

    // myDropzone is the configuration for the element that has an id attribute
    // with the value my-dropzone (or myDropzone)
    Dropzone.options.myDropzone = {
        paramName :"name",
        maxFilesize:3,
        init: function() {
            this.on("addedfile", function(file) {

            });
        }
    };

</script>

@stop
