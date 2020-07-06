<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('admin/assets/vendor/fonts/circular-std/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/charts/chartist-bundle/chartist.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/charts/morris-bundle/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/charts/c3charts/c3.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/flag-icon-css/flag-icon.min.css') }}">
    <title>Concept - Bootstrap 4 Admin Dashboard Template</title>
</head>

<body>
<!-- main wrapper -->
<!-- ============================================================== -->
<div class="dashboard-main-wrapper">
    <!-- navbar -->
    <!-- ============================================================== -->
    @include('admin.partials.navbar')

    <!-- left sidebar -->
    <!-- ============================================================== -->
    @include('admin.partials.left-sidebar')

    <!-- wrapper  -->
    <!-- ============================================================== -->
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">
                <!-- breadcrumb  -->
                <!-- ============================================================== -->
                @include('admin.partials.breadcrumb')

                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        @yield('content')
                    </div>
                </div>

            </div>
        </div>
        <!-- footer -->
        <!-- ============================================================== -->
        @include('admin.partials.footer')
    </div>
</div>

<!-- ============================================================== -->
<!-- Optional JavaScript -->
<!-- jquery 3.3.1 -->
<script src="{{ asset('admin/assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
<!-- bootstap bundle js -->
<script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
<!-- slimscroll js -->
<script src="{{ asset('admin/assets/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
<!-- main js -->
<script src="{{ asset('admin/assets/libs/js/main-js.js') }}"></script>
<!-- chart chartist js -->
<script src="{{ asset('admin/assets/vendor/charts/chartist-bundle/chartist.min.js') }}"></script>
<!-- sparkline js -->
<script src="{{ asset('admin/assets/vendor/charts/sparkline/jquery.sparkline.js') }}"></script>
<!-- morris js -->
<script src="{{ asset('admin/assets/vendor/charts/morris-bundle/raphael.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/charts/morris-bundle/morris.js') }}"></script>
<!-- chart c3 js -->
<script src="{{ asset('admin/assets/vendor/charts/c3charts/c3.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>
<script src="{{ asset('admin/assets/libs/js/dashboard-ecommerce.js') }}"></script>

<script>
    $(".delete").on("submit", function () {
        return confirm("Do you want to remove this?");
    });
</script>
</body>

</html>
