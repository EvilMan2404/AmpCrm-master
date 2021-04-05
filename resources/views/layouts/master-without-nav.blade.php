<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>CRM - Amperrenciclaje</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include('layouts.head')
  </head>

@yield('body')

@yield('content')

@include('layouts.footer-script')    
    </body>
</html>