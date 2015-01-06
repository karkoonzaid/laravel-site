@extends('admin.master')

{{-- Content --}}
@section('content')
<div class="row ">
    <div class="col-md-12 ">
        <!-- Nav tabs category -->
        <ul class="nav nav-tabs faq-cat-tabs">
            <li class="{{ $type == 'payment' ? 'active' :'' }}">
                <a href="{{ action('AdminPaymentsController@index', ['type'=>'payment']) }}">Subscription Payments&nbsp;</a>
            </li>
            <li class="{{ $type == 'refund'  ? 'active' :'' }}">
                <a href="{{ action('AdminRefundsController@index', ['type'=>'refund']) }}">Subscription Refunds&nbsp;</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content faq-cat-content" style="margin-top:20px;">
            <div class="tab-pane active in fade " id="event-tab">

                @if($type == 'payment')
                <div class="row">
                    <div class="col-md-2">
                        <nav class="nav-sidebar">
                            <ul class="nav tabs">
                                <li class="{{ !isset($_GET['status']) ? 'active':'' }} ">
                                    <a href="{{ action('AdminPaymentsController@index') }}">All</a></li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'confirmed' ) ? 'active' :'' }}">
                                    <a href="{{ action('AdminPaymentsController@index', ['type'=>'payment','status'=>'confirmed']) }}">Confirmed</a>
                                </li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'created' ) ? 'active' :'' }}">
                                    <a href="{{ action('AdminPaymentsController@index', ['type'=>'payment','status'=>'created']) }}">Created</a>
                                </li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'cancelled' ) ? 'active' :'' }}">
                                   <a href="{{ action('AdminPaymentsController@index', ['type'=>'payment','status'=>'cancelled']) }}">Cancelled</a>
                                </li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'refunding' ) ? 'active' :'' }}">
                                   <a href="{{ action('AdminPaymentsController@index', ['type'=>'payment','status'=>'refunding']) }}">Refunding</a>
                                </li>

                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'rejected' ) ? 'active' :'' }}">
                                    <a href="{{ action('AdminPaymentsController@index', ['type'=>'payment','status'=>'rejected']) }}">Rejected</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-10">
                        <div class="tab-content">
                            <div class="tab-pane active text-style" id="tab-single-1">
                                @if ($payments->count())
                                <table class="datatable table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>User</th>
                                        <th>email</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($payments as $payment)

                                        @if($payment->payable)
                                            <tr>
                                                <td>
                                                 <a href="{{action('AdminEventsController@getRequests',$payment->payable->event->id) }}">{{ $payment->payable->event->title }}</a>
                                                </td>
                                                <td>
                                                    @if($payment->user)
                                                        <a href="{{ action('AdminUsersController@show',$payment->user->id) }}">{{ $payment->user->username }}</a>
                                                    @else
                                                        User Deleted
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($payment->user)
                                                        <a href="{{ action('AdminUsersController@show',$payment->user->id) }}">{{ $payment->user->email }}</a>
                                                    @else
                                                        User Deleted
                                                    @endif
                                                </td>
                                                <td>{{ $payment->status }}</td>
                                            </tr>
                                        @endif

                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                No {{ isset($_GET['status']) ? ucfirst($_GET['status']) :'' }} payments Yet
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
                @else

                @endif

            </div>

        </div>
    </div>
</div>
@stop


