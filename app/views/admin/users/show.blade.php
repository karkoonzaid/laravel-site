@extends('admin.master')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop

{{-- Content --}}
@section('content')

<div class="page-header">
    <h3>
        Details
    </h3>
</div>
<div class="row">
    <div class="col-md-12">
        @include('site.users._detail')
    </div>
</div>
@stop