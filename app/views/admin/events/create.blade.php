@extends('admin.master')

@section('style')
    @parent
    {{ HTML::style('assets/css/jquery.datetimepicker.css') }}
    {{ HTML::style('assets/vendors/select2/select2.css') }}
    {{ HTML::style('assets/vendors/select2/select2-bootstrap.css') }}
    <style>
        .free {
            text-align: center;
        }
        .free input[type=checkbox] {
            /* Double-sized Checkboxes */
            -ms-transform: scale(2); /* IE */
            -moz-transform: scale(2); /* FF */
            -webkit-transform: scale(2); /* Safari and Chrome */
            -o-transform: scale(2); /* Opera */
            margin: 0 25px;
            vertical-align: middle;
        }
    </style>
@stop

{{-- Content --}}
@section('content')

    @include('admin.events.breadcrumb',['active'=>'info'])
    {{ Form::open(array('method' => 'POST', 'action' => array('AdminEventsController@store'), 'role'=>'form', 'files' => true)) }}

    @include('admin.events._form')

    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('tags', 'Tags:') }}
            {{ Form::select('tags[]',$tags,null,['class'=>'form-control','id'=>'tags','multiple'=>'multiple','data-placeholder'=>'Select Tags']) }}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::submit('Save', array('class' => 'btn btn-info')) }}
        </div>
    </div>
    {{ Form::close() }}

    <?php
    $latitude = '29.357';
    $longitude = '47.951';
    ?>

@stop

@section('script')
    @parent
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>

    {{HTML::script('assets/js/jquery-ui.min.js') }}
    {{HTML::script('assets/js/jquery.datetimepicker.js') }}
    {{HTML::script('assets/js/address.picker.js') }}
    {{ HTML::script('assets/vendors/select2/select2.min.js') }}

    <script type="text/javascript">

        $(function () {
            var latitude = '{{ $latitude }}';
            var longitude = '{{ $longitude }}';

            get_map(latitude, longitude);

            var addresspickerMap = $("#addresspicker_map").addresspicker({
                updateCallback: showCallback,
                elements: {
                    map: "#map",
                    lat: "#latitude",
                    lng: "#longitude"
                }
            });

            var gmarker = addresspickerMap.addresspicker("marker");
            gmarker.setVisible(true);
            addresspickerMap.addresspicker("updatePosition");

            $('#reverseGeocode').change(function () {
                $("#addresspicker_map").addresspicker("option", "reverseGeocode", ($(this).val() === 'true'));
            });

            function showCallback(geocodeResult, parsedGeocodeResult) {
                $('#callback_result').text(JSON.stringify(parsedGeocodeResult, null, 4));
            }

        });

        $(function () {
            $('#date_start').datetimepicker({
                format: 'Y-m-d H:i'
            });
            $('#date_end').datetimepicker({
                format: 'Y-m-d H:i'
            });

        });

        $(document).ready(function () {
            $('#tags').select2({
                placeholder: "Select Tags",
                allowClear: true
            });
        });

    </script>

@stop
