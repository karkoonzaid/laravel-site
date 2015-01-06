@extends('admin.master')

{{-- Content --}}
@section('content')

<div class="row ">
    <div class="col-md-12 ">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-info-sign"></span> Send Email For Subscribers.</h4>
            </div>
            {{ Form::open(array('method' => 'POST', 'action' => array('AdminEventsController@postMailFavorites',$event->id), 'role'=>'form')) }}
                <div class="modal-body" style="padding: 5px;">

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                            {{ Form::text('subject',null,['class'=>'form-control','placeholder'=>'subject']) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            {{ Form::textarea('body',null,['class'=>'form-control','placeholder'=>'body']) }}
                        </div>
                    </div>
                </div>
                <div class="panel-footer" style="margin-bottom:-14px;">
                    <input type="submit" class="btn btn-success" value="Send"/>
                </div>
            {{ Form::close() }}
        </div>

    </div>
</div>


@stop