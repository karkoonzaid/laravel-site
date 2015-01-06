@extends('admin.master')

{{-- Content --}}
@section('content')
<h1>Favorites For {{ $event->title }}</h1>

@if(count($users))
    <h3>Total {{count($users)}} Users Favorited This Event</h3>
    <a class="btn btn-default " href="{{action('AdminEventsController@getMailFavorites',$event->id)}}">
        Notify Favorites
    </a>

@else
    <h3>No Users Have Favorited This Event Yet</h3>
@endif

<h3></h3>
<p>{{ link_to_action('AdminEventsController@create', 'Add new event') }}</p>

<br>
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