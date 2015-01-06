@extends('admin.master')

{{-- Content --}}
@section('content')
<h2>Reorganize Requests for {{ $event->title }}</h2>
@if(count($event->requests))
    <h3>Total {{count($event->requests)}} User Requests</h3>
@else
    <h3>No User Requests Yet</h3>
@endif

<h3></h3>
<br>
<table class="datatable table table-striped table-bordered">
    <thead>
    <tr>
        <th>Username</th>
    </tr>
    </thead>

    <tbody>
    @if(count($event->requests))
        @foreach($event->requests as $request)
        <tr>
            <td>
                @if($request->user)
                    <a href="{{ action('AdminUsersController@show',$request->user->id) }}">{{{ $request->user->username }}} ({{ $request->user->email }})</a>
                @else
                    User Deleted
                @endif
            </td>
        </tr>
        @endforeach
    @endif
    </tbody>
</table>

@stop