@extends('layouts.master-without-nav')

@section('body')
    <body class="authentication-bg authentication-bg-pattern">
    @endsection
        Hello people
    @section('content')
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">

                                <div class="text-center w-75 m-auto">
                                   Hello people
                                </div>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->


                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <footer class="footer footer-alt">
            {{date('Y')}} &copy; V.E.R. Group
        </footer>
@endsection
