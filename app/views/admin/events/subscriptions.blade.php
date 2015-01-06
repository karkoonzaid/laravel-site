@extends('admin.master')

{{-- Content --}}
@section('content')
<h1>Subscriptions For {{ $event->title }}</h1>
<p>{{ link_to_action('AdminEventsController@create', 'Add new event') }}</p>


<div class="row ">
    <div class="col-md-12 ">

        @if(count($subscriptions))
            <h3>Total {{count($subscriptions) }} {{ isset($_GET['status']) ? strtoupper($_GET['status']) : '' }} Subscriptions</h3>
            @if(isset($_GET['status']))
                <a class="btn btn-default " href="{{action('AdminEventsController@getMailSubscribers',[$event->id,'status'=>$_GET['status']])}}">
                    Notify {{$_GET['status']}} Subscribers
                </a>
            @else
                <a class="btn btn-default " href="{{action('AdminEventsController@getMailSubscribers',[$event->id])}}">
                    Notify Subscribers
                </a>
            @endif
        @else
            <div class="info"><h3> No {{ isset($_GET['status']) ? strtoupper($_GET['status']) : '' }} Subscriptions  Yet </h3></div>
        @endif

        <!-- Tab panes -->
        <div class="tab-content faq-cat-content" style="margin-top:20px;">
            <div class="tab-pane active in fade " id="event-tab">

                @if($type == 'event')
                    <div class="row">
                        <div class="col-md-2">
                            <nav class="nav-sidebar">
                                <ul class="nav tabs">
                                    <li class="{{ !isset($_GET['status']) ? 'active':'' }} ">
                                        <a href="{{ action('AdminEventsController@getSubscriptions',['id'=>$event->id]) }}">All</a></li>
                                    <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'confirmed' ) ? 'active' :'' }}">
                                        <a href="{{ action('AdminEventsController@getSubscriptions', ['id'=>$event->id,'type'=>'event','status'=>'confirmed']) }}">Confirmed</a>
                                    </li>
                                    <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'waiting' ) ? 'active' :'' }}">
                                        <a href="{{ action('AdminEventsController@getSubscriptions', ['id'=>$event->id,'type'=>'event','status'=>'waiting']) }}">Waiting</a>
                                    </li>
                                    <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'approved' ) ? 'active' :''  }}">
                                        <a href="{{ action('AdminEventsController@getSubscriptions', ['id'=>$event->id,'type'=>'event','status'=>'approved']) }}">Approved</a>
                                    </li>
                                    <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'pending' ) ? 'active' :'' }}">
                                        <a href="{{ action('AdminEventsController@getSubscriptions', ['id'=>$event->id,'type'=>'event','status'=>'pending']) }}">Pending</a>
                                    </li>
                                    <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'cancelled' ) ? 'active' :'' }}">
                                        <a href="{{ action('AdminEventsController@getSubscriptions', ['id'=>$event->id,'type'=>'event','status'=>'cancelled']) }}">Cancelled</a>
                                    </li>
                                    <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'rejected' ) ? 'active' :'' }}">
                                        <a href="{{ action('AdminEventsController@getSubscriptions', ['id'=>$event->id,'type'=>'event','status'=>'rejected']) }}">Rejected</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-md-10">
                            <div class="tab-content">
                                <div class="tab-pane active text-style" id="tab-single-1">
                                    @if ($subscriptions->count())
                                    <table class="datatable table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>username</th>
                                            <th>email</th>
                                            <th>Status</th>
                                            <th>Subscribed on</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($subscriptions as $subscription)
                                        <tr>
                                            <td>
                                                <a href="{{action('AdminEventsController@getRequests',$subscription->event->id) }}">{{ $subscription->event->title }}</a>
                                            </td>
                                            <td>
                                                @if($subscription->user)
                                                    <a href="{{ action('AdminUsersController@show',$subscription->user->id) }}">{{ $subscription->user->username }}</a>
                                                @else
                                                    User Deleted
                                                @endif
                                            </td>
                                            <td>
                                                @if($subscription->user)
                                                    <a href="{{ action('AdminUsersController@show',$subscription->user->id) }}">{{ $subscription->user->email }}</a>
                                                @else
                                                    User Deleted
                                                @endif
                                            </td>
                                            <td><a href="{{ URL::action('AdminSubscriptionsController@edit',$subscription->id)}}">{{ $subscription->status }}</a></td>
                                            <td>{{ $subscription->formattedCreated() }}</td>
                                            <td>
                                                {{ Form::open(array('method' => 'DELETE', 'action' => array('AdminSubscriptionsController@destroy', $subscription->id))) }}
                                                <a class="btn btn-xs btn-info" href="{{ URL::action('AdminSubscriptionsController@edit',  array($subscription->id)) }}">Edit</a>
                                                {{ Form::submit('Delete', array('class' => 'btn btn-xs btn-danger')) }}
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

                @endif

            </div>

        </div>
    </div>
</div>


@stop