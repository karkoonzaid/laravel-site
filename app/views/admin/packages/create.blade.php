@extends('admin.master')

@section('style')
@parent
@stop

{{-- Content --}}
@section('content')
@include('admin.events.breadcrumb',['active'=>'info'])
{{ Form::open(array('method' => 'POST', 'action' => array('AdminPackagesController@store'), 'role'=>'form', 'files' => true)) }}

<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('title_ar', 'Title in Arabic:*') }}
        {{ Form::text('title_ar',NULL,array('class'=>'form-control')) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('title_en', 'Title in English:') }}
        {{ Form::text('title_en',NULL,array('class'=>'form-control')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('description_ar', 'Description in Arabic:*') }}
        {{ Form::textarea('description_ar',NULL,array('class'=>'form-control wysihtml5')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('description_en', 'Description in English:') }}
        {{ Form::textarea('description_en',NULL,array('class'=>'form-control wysihtml5')) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-2 col-sm-4 col-xs-4">
        {{ Form::label('free_event', 'Is this a Free Package ?:') }}
        <br/>
        {{ Form::checkbox('free', '1', true,['class'=>'free']) }}
    </div>
    <div class="form-group col-md-10 col-sm-8 col-xs-8">
        {{ Form::label('price', 'Package Price:') }}
        {{ Form::text('price',NULL,array('class'=>'form-control','id'=>'price')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        {{ Form::submit('Save', array('class' => 'btn btn-info')) }}
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
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>

{{HTML::script('assets/js/jquery-ui.min.js') }}
{{HTML::script('assets/js/jquery.datetimepicker.js') }}
{{HTML::script('assets/js/address.picker.js') }}

<script type="text/javascript">

    $('document').ready(function() {
        // initial load
        if ($('.free').is(':checked')) {
            $("#price").prop('disabled', true);
            $("#price").val('0');
        } else if ($('#price').val() == 0) {
            // on a reload
            $('.free').prop('checked', true);
            $("#price").prop('disabled', true);
        }
    });

    $(".free").change(function() {
        if(this.checked) {
            $("#price").val('0');
            $("#price").prop('disabled', true);
        } else {
            $("#price").val('0');
            $("#price").prop('disabled', false);
        }
    });

</script>

@stop
