<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kaizen Courses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file://
    ==========================

    <!-- arabic and english switcher -->
    {{ HTML::style('css/bootstrap.min.css') }}
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

</head>

<div class="container">
    <div id="header" class="row">
        <div class="row">
            <div class="col-md-4">
                <a href="/">{{ HTML::image('images/Logo.png') }}</a>
            </div>
        </div>
        <!-- end of row-->
    </div>
    <div id="content" class="row">
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h1> Sorry</h1>
            <div class="error-details">
               {{$body}}
            </div>
        </div>
    </div>
    <!-- end content -->
</div>
<!--end of container-->

</body>
</html>

