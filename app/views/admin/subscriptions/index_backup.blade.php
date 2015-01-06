@extends('admin.master')

{{-- Content --}}
@section('content')
<div class="row " >
    <div class="col-md-12 ">
        <!-- Nav tabs category -->
        <ul class="nav nav-tabs faq-cat-tabs">
            <li class="{{ (isset($_GET['type']) && $_GET['type'] != 'package' ) ? 'active' :'' }}"><a href="{{ action('AdminSubscriptionsController@index', ['type'=>'event']) }}">Event Subscriptions&nbsp;</a></li>
            <li class="{{ (isset($_GET['type']) && $_GET['type'] == 'package' ) ? 'active' :'' }}"><a href="{{ action('AdminSubscriptionsController@index', ['type'=>'package']) }}" >Package Subscriptions&nbsp;</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content faq-cat-content" style="margin-top:20px;">
            <div class="tab-pane active in fade " id="event-tab">

                <div class="row">
                    <div class="col-md-2">
                        <nav class="nav-sidebar">
                            <ul class="nav tabs">
                                <li class="{{ !isset($_GET['status']) ? 'active':'' }} "><a href="{{ action('AdminSubscriptionsController@index') }}" >All</a></li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'confirmed' ) ? 'active' :'' }}"><a href="{{ action('AdminSubscriptionsController@index', ['type'=>'event','status'=>'confirmed']) }}" >Confirmed</a></li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'waiting' ) ? 'active' :'' }}"><a href="{{ action('AdminSubscriptionsController@index', ['type'=>'event','status'=>'waiting']) }}">Waiting</a></li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'approved' ) ? 'active' :''  }}"><a href="{{ action('AdminSubscriptionsController@index', ['type'=>'event','status'=>'approved']) }}">Approved</a></li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'pending' ) ? 'active' :'' }}"><a href="{{ action('AdminSubscriptionsController@index', ['type'=>'event','status'=>'pending']) }}">Pending</a></li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'rejected' ) ? 'active' :'' }}"><a href="{{ action('AdminSubscriptionsController@index', ['type'=>'event','status'=>'rejected']) }}">Rejected</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-10">
                        <div class="tab-content">
                            <div class="tab-pane active text-style" id="tab-single-1">
                                @if ($subscriptions->count())
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>User</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td>
                                            <a href="{{action('AdminEventsController@getRequests',$subscription->event->id) }}">{{ $subscription->event->title }}</a>
                                        </td>
                                        <td>{{ $subscription->user->username }}</td>
                                        <td>{{ $subscription->status }}</td>
                                        <td>
                                            <a href="{{ URL::action('AdminSubscriptionsController@edit',  array($subscription->id), array('class' => 'btn btn-info')) }}">Edit</a>
                                        </td>
                                        <td>
                                            {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminSubscriptionsController@destroy', $subscription->id))) }}
                                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                No Subscriptions Yet
                                @endif

                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="package-tab">

                <div class="row">
                    <div class="col-md-2">
                        <nav class="nav-sidebar">
                            <ul class="nav tabs">
                                <li class="{{ !isset($_GET['status']) ? 'active':'' }} "><a href="{{ action('AdminSubscriptionsController@index') }}" >All</a></li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'confirmed' ) ? 'active' :'' }}"><a href="{{ action('AdminSubscriptionsController@index', ['type'=>'package','status'=>'confirmed']) }}" >Confirmed</a></li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'waiting' ) ? 'active' :'' }}"><a href="{{ action('AdminSubscriptionsController@index', ['type'=>'package','status'=>'waiting']) }}">Waiting</a></li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'approved' ) ? 'active' :''  }}"><a href="{{ action('AdminSubscriptionsController@index', ['type'=>'package','status'=>'approved']) }}">Approved</a></li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'pending' ) ? 'active' :'' }}"><a href="{{ action('AdminSubscriptionsController@index', ['type'=>'package','status'=>'pending']) }}">Pending</a></li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'rejected' ) ? 'active' :'' }}"><a href="{{ action('AdminSubscriptionsController@index', ['type'=>'package','status'=>'rejected']) }}">Rejected</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-10">
                        <div class="tab-content">
                            <div class="tab-pane active text-style" id="tab-package-1">
                                @if ($subscriptions->count())
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>User</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td>
                                            <a href="{{action('AdminEventsController@getRequests',$subscription->event->id) }}">{{ $subscription->event->title }}</a>
                                        </td>
                                        <td>{{ $subscription->user->username }}</td>
                                        <td>{{ $subscription->status }}</td>
                                        <td>
                                            <a href="{{ URL::action('AdminSubscriptionsController@edit',  array($subscription->id), array('class' => 'btn btn-info')) }}">Edit</a>
                                        </td>
                                        <td>
                                            {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminSubscriptionsController@destroy', $subscription->id))) }}
                                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                No Subscriptions Yet
                                @endif

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop


