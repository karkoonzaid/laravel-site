@extends('site.layouts._one_column')

@section('content')

    <div class="col-md-12">
        <div class="alert alert-info">{{ trans('auth.signup.valid_information')}}</div>

        {{ Form::open(array('method' => 'POST', 'action'=>array('AuthController@postSignup'),'class'=>'form')) }}

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label>{{ trans('auth.signup.name_ar')  }}</label>
                        {{ Form::text('name_ar',NULL,array('class'=>'form-control input-lg','placeholder'=> trans('auth.signup.name_ar'))) }}
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label>{{ trans('auth.signup.name_en')  }}</label>

                        {{ Form::text('name_en',NULL,array('class'=>'form-control input-lg','placeholder'=> trans('auth.signup.name_en'))) }}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label>{{ trans('word.email')  }}</label>
                        {{ Form::text('email',NULL,array('class' => 'form-control input-lg','placeholder' => trans('word.email'))) }}
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label>{{ trans('word.username')  }}</label>
                        {{ Form::text('username',NULL,array('class' => 'form-control input-lg','placeholder' => trans('word.username'))) }}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label>{{ trans('word.password')  }}</label>
                        {{ Form::password('password',array('class' => 'form-control input-lg','placeholder' => trans('word.password'))) }}
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label>{{ trans('word.password_confirmation')  }}</label>
                        {{ Form::password('password_confirmation',array('class' => 'form-control input-lg','placeholder' => trans('word.password_confirmation'))) }}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        <label>{{ trans('word.countrycode')  }}</label>
                        @include('site.partials._countrycode-dropdown')
                    </div>
                    <div class="col-sm-8 col-md-8">
                        <label>{{ trans('word.mobile')  }}</label>
                        <div class="input-group">
                            {{ Form::text('mobile',NULL,array('id'=> 'mobile','class'=>'form-control input-lg','placeholder'=> trans('word.mobile'))) }}
                            <span class="input-group-addon" id="mobile-code">+</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-lg btn-success btn-block signup-btn" type="submit">
                    {{ trans('auth.signup.submit') }}
                </button>
            </div>

        {{ Form::close() }}
    </div>

@stop
@section('script')
@parent
    <script>
        $('#countrycode').change(function() {
            $('#mobile-code').html(this.value+'+');
        });
    </script>
@stop
