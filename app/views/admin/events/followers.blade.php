@extends('admin.master')

{{-- Content --}}
@section('content')
<h1>Followers For <a href="{{ action('AdminEventsController@index') }}"> {{ $event->title }}</a></h1>
@if(count($users))
    <!-- Button trigger modal -->
        <h3>Total {{count($users)}} Users Followed This Event</h3>

        <a class="btn btn-default " href="{{action('AdminEventsController@getMailFollowers',$event->id)}}">
            Notify Followers
        </a>

@endif
@if(count($users))
<h3>Total {{count($users) }} Users Following This Event</h3>
@else
<h3>No Users are Following This Event Yet</h3>
@endif


<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Username</th>
        <th>Email</th>
    </tr>
    </thead>

    <tbody>
    @foreach($users as $user)
    <tr>

        <td><a href="{{ action('UserController@getProfile',$user->id) }}">{{{ $user->username }}}</a></td>
        <td>{{{ $user->email }}} </td>

    </tr>
    @endforeach
    </tbody>
</table>

@stop