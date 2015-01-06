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

                @if($type == 'refund')
                <div class="row">
                    <div class="col-md-2">
                        <nav class="nav-sidebar">
                            <ul class="nav tabs">
                                <li class="{{ !isset($_GET['status']) ? 'active':'' }} ">
                                    <a href="{{ action('AdminRefundsController@index') }}">All</a></li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'confirmed' ) ? 'active' :'' }}">
                                    <a href="{{ action('AdminRefundsController@index', ['type'=>'refund','status'=>'pending']) }}">Pending</a>
                                </li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'created' ) ? 'active' :'' }}">
                                    <a href="{{ action('AdminRefundsController@index', ['type'=>'refund','status'=>'confirmed']) }}">Confirmed</a>
                                </li>
                                <li class="{{ (isset($_GET['status']) && $_GET['status'] == 'cancelled' ) ? 'active' :'' }}">
                                   <a href="{{ action('AdminRefundsController@index', ['type'=>'refund','status'=>'cancelled']) }}">Cancelled</a>
                                </li>

                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-10">
                        <div class="tab-content">
                            <div class="tab-pane active text-style" id="tab-single-1">
                                @if ($refunds->count())
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>User</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($refunds as $refund)
                                        @if($refund->payment)
                                            <tr>
                                                <td>
                                                 <a href="{{action('AdminEventsController@getRequests',$refund->payment->payable->event->id) }}">{{ $refund->payment->payable->event->title }}</a>
                                                </td>

                                                <td><a href="{{ action('AdminUsersController@show',$refund->user->id) }}">{{ $refund->user->username }}</a></td>
                                                <td>{{ $refund->status }}</td>
                                            </tr>
                                        @endif

                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                No {{ isset($_GET['status']) ? ucfirst($_GET['status']) :'' }} Refund requests Yet
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


