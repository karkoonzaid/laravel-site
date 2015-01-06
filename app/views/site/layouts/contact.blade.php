@extends('site.layouts._one_column')

@section('content')

    <div class="row">
    <div class="col-md-1"></div>
       <div class="col-md-10">
           <address>
               <h2 style="background-color: rgba(221, 220, 219, 0.83); padding:10px;">Contact Us</h2>
               @if($contact)
               <b>{{ trans('word.email')  }}</b> : {{ $contact->email }}</br>
               <b>{{ trans('word.address')}}</b> : {{ $contact->address_en }}</br>
               <b>{{ trans('word.phone')  }}</b> : {{ $contact->phone }} </br>
               <b>{{ trans('word.mobile') }}</b> : {{ $contact->mobile }} </br>
               @endif
           </address>
       </div>
       <div class="col-md-1"></div>
    </div>


    <div class="row">
    <div class="col-md-1"></div>
        <div class="col-md-10">
            {{ Form::open(array('method' => 'POST', 'action' => array('ContactsController@contact'), 'role'=>'form')) }}

            <div class="form-group">
                <label for="exampleInputEmail">{{ trans('word.email') }}</label>
                {{ Form::text('sender_email', null , ['class' => 'form-control', 'placeholder' => trans('word.email') ]) }}
            </div>
            <div class="form-group">
                <label for="name">{{ trans('word.name') }}</label>
                {{ Form::text('sender_name', null , ['class' => 'form-control', 'placeholder' => trans('word.name') ]) }}
            </div>
            <div class="form-group">
                <label for="comment">{{ trans('word.comment') }}</label>
                {{ Form::textarea('body', null , ['class' => 'form-control', 'placeholder' => trans('word.comment')]) }}
            </div>
            <button type="submit" class="btn btn-default">{{ trans('word.contact') }}</button>
            {{ Form::close() }}
        </div>
        <div class="col-md-1"></div>
    </div>

@stop