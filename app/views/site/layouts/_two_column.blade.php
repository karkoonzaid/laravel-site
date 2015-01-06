<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" >
    @section('content')
    @show
</div>
<div class="col-md-4 col-xs-12">
    @section('sidebar')
        @include('site.events._latest')
        @include('site.blog._latest')
        @include('site.partials.twitter')
        @include('site.partials.newsletter')
    @show
</div>