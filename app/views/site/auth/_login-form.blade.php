{{ Form::open(['action' => 'AuthController@postLogin', 'method' => 'post'], ['class'=>'form']) }}
<div class="col-md-6 col-sm-12">
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon  glyphicon-user"></i></span>
            {{ Form::text('email',null,['class'=>'form-control', 'placeholder'=> trans('word.email')]) }}
        </div>
    </div>
</div>
<div class="col-md-6 col-sm-12">
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon  glyphicon-lock"></i></span>
            {{ Form::password('password',['class'=>'form-control', 'placeholder'=> trans('word.password')]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 form-group
        @if ( App::getLocale() == 'en')
            pull-right
        @else
            pull-left
        @endif
        ">
        {{ Form::checkbox('remember', '1', true,  ['id' => 'remember']) }}
        {{ trans('word.remember')}}
        <button type="submit" class="btn btn-default">{{ trans('word.login') }}</button>
        <a href="{{ action('AuthController@getSignup') }}" type="submit" class="btn btn-default">{{ trans('word.register') }}</a>
    </div>
</div>
{{ Form::close() }}