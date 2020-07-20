<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        .has-error{
            border:1px solid red;
        }
        .list-group.inner-list li{
            border:none;
        }
    </style>
</head>

<body>

@include('admin.partials.navbar')

<div class="container my-4">
    <div class="row">
        <div class="col-3">
            @include('admin.partials.sidebar')
        </div>

        <div class="col-9">
{{--            @include('admin.partials.breadcrumb')--}}

            @yield('content')
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @include('admin.partials.footer')
        </div>
    </div>
</div>

<!-- scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script>
    $(".delete").on("click", function () {
        return confirm("Do you want to remove this?");
    });

    $("a.delete").on("click", function () {
        event.preventDefault();
        var orderId = $(this).attr('order-id');
        if (confirm("Do you want to remove this?")) {
            document.getElementById('delete-form-' + orderId ).submit();
        }
    });

    $(".restore").on("click", function () {
        return confirm("Do you want to restore this?");
    });

    function showHideConfigurableAttributes() {
        var productType = $(".product-type").val();

        if (productType == 'configurable') {
            $(".configurable-attributes").show();
        } else {
            $(".configurable-attributes").hide();
        }
    }

    $(function(){
        showHideConfigurableAttributes();
        $(".product-type").change(function() {
            showHideConfigurableAttributes();
        });
    });
</script>

@yield('js')
</body>

</html>
