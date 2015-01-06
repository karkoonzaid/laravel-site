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

    <h2>Edit {{ $event->title }}</h2>

    @include('admin.events.breadcrumb',['active'=>'info'])

    {{ Form::model($event, array('method' => 'PATCH', 'action' => array('AdminEventsController@update', $event->id), 'role'=>'form', 'files' => true)) }}

    @include('admin.events._form')

    <div class="row">
        <div class="form-group col-md-12">
            <p>{{ Form::label('tags', 'Tags:', array('class','pull-left')) }}</p>
            <select id="tags" name="tags[]" class="form-control" multiple="multiple" data-placeholder="Select Tags">
                @foreach($tags as $key=>$value)
                    <option value="{{ $key }}"
                        @if(in_array($key,$dbTags))
                            selected="selected"
                        @endif
                    >{{$value}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            {{ link_to_action('EventsController@show', 'Cancel', $event->id, array('class' => 'btn')) }}
        </div>
    </div>

    {{ Form::close() }}

    @include('admin.photos._delete',['record'=>$event])

    <?php
    $latitude = $event->latitude ? $event->latitude : '29.357';
    $longitude = $event->longitude ? $event->longitude : '47.951';
    ?>
@stop

@section('script')
    @parent
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>

    {{HTML::script('assets/js/jquery-ui.min.js') }}
    {{HTML::script('assets/js/jquery.datetimepicker.js') }}
    {{HTML::script('assets/js/address.picker.js') }}
    {{ HTML::script('assets/vendors/select2/select2.min.js') }}


    <script>
        //    $('document').ready(function() {
        //
        //          if ($('#price').val() > 0) {
        //              $('.free').prop('checked', false);
        //          }
        //
        //    });
        //
        //    $(".free").change(function() {
        //        if(this.checked) {
        //            $("#price").val('0');
        ////            $("#price").prop('disabled', true);
        //        } else {
        //            $("#price").val('0');
        ////            $("#price").prop('disabled', false);
        //        }
        //    });

        //        $('document').ready(function() {
        //            // initial load
        //            if ($('.free').is(':checked')) {
        //                $("#price").prop('disabled', true);
        //                $("#price").val('0');
        //            } else if ($('#price').val() == 0) {
        //                // on a reload
        //                $('.free').prop('checked', true);
        //                $("#price").prop('disabled', true);
        //            }
        //        });
        //
        //        $(".free").change(function() {
        //            if(this.checked) {
        //                $("#price").val('0');
        //                $("#price").prop('disabled', true);
        //            } else {
        //                $("#price").val('0');
        //                $("#price").prop('disabled', false);
        //            }
        //        });

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
                format: 'Y-m-d H:i',
                onShow: function (ct) {
                }
            });


            $('#date_end').datetimepicker({
                format: 'Y-m-d H:i',
                onShow: function (ct) {
                }
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

