@extends('site.layouts._two_column')

@section('sidebar')
    @include('site.events._expired')
    @include('site.events._category')
    @include('site.events._tags')
    @parent
@stop

@section('content')

    {{-- Include Events Search Module --}}
    @include('site.events._search')

    @if(count($events))

        @foreach($events as $event)
            {{-- Include Events Results --}}
            @include('site.events._results')
        @endforeach

        <?php echo $events->appends(Request::except('page'))->links(); ?>

    @else
        <h1> {{ trans('word.no_results') }} </h1>
    @endif

@stop
