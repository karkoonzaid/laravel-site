<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ ! empty($title) ? $title . ' - ' : '' }} Kaizen Admin</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @section('style')

        {{ HTML::style('assets/css/bootstrap.min.css') }}
        {{ HTML::style('css/font-awesome.min.css') }}
{{--        {{ HTML::style('assets/css/wysihtml5/prettify.css') }}--}}
{{--        {{ HTML::style('assets/css/wysihtml5/bootstrap-wysihtml5.css') }}--}}
        {{ HTML::style('assets/css/datatables.css') }}
        {{ HTML::style('assets/css/custom.css') }}

        <style>
            .container-fluid {
                padding:0 50px;
            }
        </style>
    @show


</head>

<body>
<!-- Container -->
<div class="container-fluid ">

    @include('admin.partials.navigation')
    @include('admin.partials.confirm')
    <!-- ./ navbar -->

    <!-- Notifications -->
    @include('admin.partials.notification')
    <!-- ./ notifications -->

    <!-- Content -->
    @section('content')
    @show
    <!-- ./ content -->

    <!-- Footer -->
    @include('admin.layouts.footer')
    <!-- ./ Footer -->


</div>
<!-- ./ container -->

    <!-- Javascript -->
    @section('script')


    {{ HTML::script('assets/js/jquery.min.js') }}
    {{ HTML::script('assets/js/bootstrap.min.js') }}
    {{--{{ HTML::script('assets/js/wysihtml5/wysihtml5-0.3.0.js') }}--}}
    {{--{{ HTML::script('assets/js/wysihtml5/bootstrap-wysihtml5.js') }}--}}
    {{ HTML::script('assets/js/nicEdit.js') }}
    {{ HTML::script('assets/js/datatables-bootstrap.js') }}
    {{ HTML::script('assets/js/datatables.js') }}

    <script type="text/javascript">
//        $('.wysihtml5').wysihtml5();
//        $('.wysihtml5').Editor();
//        nicEditors.allTextAreas();

//        $('button[name="remove"]').on('click', function(e){
//            var $form=$(this).closest('form');
//            e.preventDefault();
//            $('#confirm').modal({ backdrop: 'static', keyboard: false })
//                .one('click', '#delete', function (e) {
//                    $form.trigger('submit');
//                });
//        });
        $('.delete-btns').on('click', function(e){
            var $form=$(this).closest('form');
                e.preventDefault();
                $('#confirm').modal({ backdrop: 'static', keyboard: false })
                    .one('click', '#delete', function (e) {
                        $form.trigger('submit');
                    }
                );
        });
        $(document).ready(function() {
            $('.datatable').dataTable({
                "sPaginationType": "bs_four_button",
                "iDisplayLength" : 100
            });
            $('.datatable').each(function(){
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Search');
                search_input.addClass('form-control');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.addClass('form-control input-sm');
            });
            nicEditors.allTextAreas();
        });
    </script>

    @show

</body>

</html>