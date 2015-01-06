@extends('site.layouts._two_column')

@section('sidebar')
    @include('site.blog._category')
    @include('site.blog._tags')
    @parent
@stop

@section('content')

    @foreach ($posts as $post)

        @include('site.blog._results')

    @endforeach

    {{ $posts->links() }}

@stop
