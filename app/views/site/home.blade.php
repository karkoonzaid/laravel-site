<!-- Extends From Two Column Layou -->
@extends('site.layouts._two_column')

<!-- Include Slider -->
@include('site.events.slider')

@include('site.partials.ads')

<!-- Content Section -->
@section('content')
    @parent
@stop