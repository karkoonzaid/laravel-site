@extends('admin.master')

@section('style')
    @parent
    {{ HTML::style('assets/css/jquery.datetimepicker.css') }}
    {{ HTML::style('assets/vendors/select2/select2.css') }}
    {{ HTML::style('assets/vendors/select2/select2-bootstrap.css') }}
    {{ HTML::style('assets/css/jquery.datetimepicker.css') }}
    <style>
        .panel-group { margin-bottom: 20px }

    </style>
@stop

@section('script')
    @parent
    {{ HTML::script('assets/vendors/select2/select2.min.js') }}
    <script>

    </script>
@stop

{{-- Content --}}
@section('content')

    @include('admin.events.breadcrumb',['active'=>'options','link'=>'true','id'=>$setting->id])

    {{ Form::model($setting, array('method' => 'POST', 'action' => array('AdminSettingsController@updateOptions',$setting->id), 'role'=>'form')) }}

    <div class="row">
        <?php $i=1; ?>
        @foreach(explode(',',$setting->registration_types) as $registrationType)
            <div class="col-md-12">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i}}">
                                <h4 class="panel-title">
                                    <i class="fa fa-th"></i> {{$registrationType}}
                                </h4>
                            </a>
                        </div>

                        <div id="collapse{{$i}}" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="panel-inner">
                                    <div class="row">
                                        @if(!$freeEvent)
                                            @foreach($setting->settingable->eventCountries as $country)
                                                <?php
                                                $eventPrice = $country->price($setting->settingable->id,$registrationType);
                                                if($eventPrice) { $price = $eventPrice->price; } else { $price = null;}
                                                ?>
                                                @if($country->currency && $country->iso_code)
                                                    <div class="form-group col-md-2">
                                                        {{ Form::label(strtolower($registrationType).'_price', $registrationType .' Price in '.$country->currency.':') }}
                                                        {{ Form::text(substr($registrationType,0,1).'_price_'.$country->iso_code,$price,['class'=>'form-control'])}}
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {{ Form::label(strtolower($registrationType).'_total_seats', $registrationType .' Seats:') }}
                                            {{ Form::text(strtolower($registrationType).'_total_seats',null,['class'=>'form-control'])}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {{ Form::label(strtolower($registrationType).'_description_en', $registrationType.' Description in English') }}
                                            {{ Form::textarea(strtolower($registrationType).'_description_en',null,['class'=>'form-control wysihtml5','rows'=>'5'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label(strtolower($registrationType).'_description_ar', $registrationType.' Description in Arabic') }}
                                            {{ Form::textarea(strtolower($registrationType).'_description_ar',null,['class'=>'form-control wysihtml5','rows'=>'5'])}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $i++; ?>
            <hr>
        @endforeach
    </div>

    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::submit('Save', array('class' => 'col-md-12 btn btn-lg btn-success')) }}
        </div>
    </div>

    {{ Form::close() }}

@stop


