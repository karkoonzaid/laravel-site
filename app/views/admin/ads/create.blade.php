@extends('admin.master')

@section('content')
    <h1>Create an Ad </h1>

    {{ Form::open(array('method' => 'POST', 'action' => array('AdminAdsController@store'), 'role'=>'form', 'files' => true)) }}
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
