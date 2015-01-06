<!-- Extends From Two Column Layou -->
@extends('site.layouts._two_column')

@section('sidebar')
    @include('site.events._tags')
    @parent
@stop
@section('content')

    @foreach($posts as $post)
        @include('site.blog._results')
    @endforeach

@stop