@yield('css')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<!-- App css -->
<link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/css/additional.css')}}" rel="stylesheet" type="text/css"/>