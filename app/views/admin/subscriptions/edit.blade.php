@extends('admin.master')

{{-- Content --}}
@section('content')

<h1>Edit Request for {{ $subscription->user->username }} in event {{ $subscription->event->title }} </h1>

{{ Form::model($subscription, array('method' => 'PATCH', 'role'=>'form', 'action' => array('AdminSubscriptionsController@update', $subscription->id))) }}
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('approval_type', 'Approval Type:') }}
            <select name="status" id="status" class="form-control">
                <option value="">Select one</option>
                @foreach($subscriptionStatuses as $status)
                    <option value="{{ $status }}"
                    @if( Form::getValueAttribute('status') == $status)
                        selected = "selected"
                    @endif
                    >{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-6">
            {{ Form::textarea('feedback', NULL ,array('class'=>'form-control','placeholder'=>'Your request have been ... ')) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            {{ link_to_action('AdminEventsController@getRequests', 'Cancel', $subscription->event_id, array('class' => 'btn')) }}
        </div>
    </div>

{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
