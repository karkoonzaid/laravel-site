@extends('admin.master')

@section('style')
    @parent
    {{ HTML::style('assets/vendors/select2/select2.css') }}
    {{ HTML::style('assets/vendors/select2/select2-bootstrap.css') }}
@stop

@section('content')
    <h1>Add Blog Post</h1>

    {{ Form::open(array('method' => 'POST', 'action' => array('AdminBlogsController@store'), 'role'=>'form', 'files' => true)) }}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('user_id', 'Author:',array('class'=>'control-label')) }}
                {{ Form::select('user_id', $author,NULL,array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('category_id', 'Category:') }}
                {{ Form::select('category_id', $category,NULL,array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label" for="title">Post Title in Arabic</label>
                {{ Form::text('title_ar', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label" for="title">Post Title in English</label>
                {{ Form::text('title_en', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label" for="content">Description in Arabic</label>
                {{ Form::textarea('description_ar', null, ['class' => 'form-control wysihtml5']) }}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label" for="content">Description in English</label>
                {{ Form::textarea('description_en', null, ['class' => 'form-control wysihtml5']) }}
            </div>
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('tags', 'Tags:') }}
            {{ Form::select('tags[]',$tags,null,['class'=>'form-control','id'=>'tags','multiple'=>'multiple','data-placeholder'=>'Select Tags']) }}
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>

    </div>

	{{ Form::close() }}
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


@section('script')
    @parent
    {{ HTML::script('assets/vendors/select2/select2.min.js') }}

    <script>
        $(document).ready(function() {
            $('#tags').select2({
                placeholder: "Select Tags",
                allowClear: true
            });
        });
    </script>

@stop