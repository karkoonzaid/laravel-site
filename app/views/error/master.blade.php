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
    {{ HTML::style(asset('css/intlTelInput.css')); }}
    @if ( App::getLocale() == 'ar')
        {{ HTML::style('css/bootstrap-rtl.min.css') }}
    @endif

    {{ HTML::style('css/custom.css') }}

    @if ( App::getLocale() == 'en')
        {{ HTML::style('css/custom-en.css') }}
    @endif

    @show

</head>
<body>
    <div class="container">
        <!-- header -->
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <a href="/">{{ HTML::image('images/Logo.png','kaizen',array('class'=>'img-responsive')) }}</a>
            </div>
            <div class="col-md-7 col-sm-12 visible-lg visible-md visible-sm top30">
            </div>
            <div class="col-md-1 col-sm-1  visible-lg visible-md visible-sm top30">
            </div>
        </div>
        <div class="row">
            <div class="row">
                @include('site.partials.navigation')
            </div>
            <div class="row visible-xs">
                <div class="col-xs-12">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
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

    @show

</body>
</html>