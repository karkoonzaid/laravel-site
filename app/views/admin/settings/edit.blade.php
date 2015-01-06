@extends('admin.master')

@section('style')
    @parent
    {{ HTML::style('assets/css/jquery.datetimepicker.css') }}
    {{ HTML::style('assets/vendors/select2/select2.css') }}
    {{ HTML::style('assets/vendors/select2/select2-bootstrap.css') }}
    {{ HTML::style('assets/css/jquery.datetimepicker.css') }}
@stop

@section('script')
    @parent
    {{ HTML::script('assets/vendors/select2/select2.min.js') }}
    <script>
        $(document).ready(function() {
            $('#registration_types').select2({
                placeholder: "Select Reigstration Types",
                allowClear: true,
                maximumSelectionSize: 3
            });
            $('#country_ids').select2({
                placeholder: "Select Countries For the Event",
                allowClear: true
            });
        });
    </script>
@stop

{{-- Content --}}
@section('content')

    @include('admin.events.breadcrumb',['active'=>'settings'])

    {{ Form::model($setting, array('method' => 'PATCH', 'action' => array('AdminSettingsController@update',$setting->id), 'role'=>'form')) }}

        <div class="row">

            {{ Form::hidden('store',Input::get('store')) }}

            <div class="form-group col-md-6">
                {{ Form::label('approval_type', 'Approval Type:') }}
                <select name="approval_type" id="approval_type" class="form-control">
                    <option value="">Select one</option>
                    @foreach($approvalTypes as $approvalType)
                        <option value="{{ $approvalType }}"
                        @if( Form::getValueAttribute('approval_type') == $approvalType)
                            selected = "selected"
                        @endif
                        >{{ $approvalType }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                {{ Form::label('registration_types', 'Registration Type:') }}
                <select id="registration_types" name="registration_types[]" class="form-control" multiple="multiple" >
                    @foreach($registrationTypes as $registrationType)
                        <option value="{{ $registrationType }}"
                            @if(in_array($registrationType,$currentRegistrationTypes))
                                selected="selected"
                            @endif
                        >{{$registrationType}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="form-group col-md-6">
                {{ Form::label('country_ids', 'Currenices: ( Please make sure the countries have valid currency') }}
                <select id="country_ids" name="country_ids[]" class="form-control" multiple="multiple" >
                    @foreach($countries as $key => $value)
                        <option value="{{ $key }}"
                        @if(in_array($key, $currentCountries))
                            selected="selected"
                        @endif
                        >{{$value}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr>

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


