<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>AMPCRM - CRM of the future</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="shortcut icon" href="assets/images/favicon.ico"> -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/favicons/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/favicons/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/favicons/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('/favicons/site.webmanifest')}}">
    @include('layouts.head')

</head>

<body class="left-side-menu-dark">

<!-- Begin page -->
<div id="wrapper">
@include('layouts.topbar')
@include('layouts.sidebar')
<!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            @yield('content')
            @include('layouts.right-sidebar')
        </div> <!-- content -->
        @include('layouts.footer')
    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->
</div>
<!-- END wrapper -->
@include('layouts.calculator-modal')
@include('layouts.footer-script')
</body>
</html>
