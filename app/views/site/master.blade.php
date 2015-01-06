<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ ! empty($title) ? $title . ' - ' : '' }} Kaizen</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @section('style')
        <style>
        @import url(http://fonts.googleapis.com/earlyaccess/droidarabickufi.css);
        html,body {
            font-family: 'Droid Arabic Kufi' !important;
            background: #f5f5f5 !important;
        }
        h1,h2,h3,h4,span,p,div,table {
        font-family: 'Droid Arabic Kufi' !important;
        }
        </style>
    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/font-awesome.min.css') }}
    {{ HTML::style('css/intlTelInput.css'); }}
    @if ( App::getLocale() == 'ar')
        {{ HTML::style('css/bootstrap-rtl.min.css') }}
    @endif

    {{ HTML::style('css/custom.css') }}

    @show

</head>
<body>
    <div class="container">
        <!-- header -->
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <a href="/">{{ HTML::image('images/Logo.png','kaizen',array('class'=>'img-responsive')) }}</a>
            </div>

            <!-- Show only in big Screen -->
            <div class="col-md-6 col-sm-10 visible-lg visible-md visible-sm top30">
                @section('login')
                    @include('site.partials.login')
                @show
            </div>
            <div class="col-md-2 col-sm-2  visible-lg visible-md visible-sm top30">
                @include('site.partials.region')
            </div>
        </div>
        <div class="row">
            <div class="row">
                @include('site.partials.navigation')
            </div>

            <!-- show only in mobiles -->
            <div class="visible-xs">
                <div class="row">
                    @include('site.partials.login')
                </div>
            </div>
            <!-- End mobile Div -->

            <div class="row">
                <div class="col-md-12">
                    @include('site.partials.notification')
                </div>
            </div>

            <div class="row">
                {{ $content }}
            </div>
            <div class="row">
                @include('site.partials.footer')
            </div>
        </div>
    </div>
    <!--end of container-->

    <!-- Javascript -->
    @section('script')

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @include('site.partials.google-analytics')
    @show

</body>
</html>