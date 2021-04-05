@extends('layouts.master-without-nav')

@section('body')
    <body class="authentication-bg authentication-bg-pattern">
    @endsection

    @section('content')

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">

                                <div class="text-center w-75 m-auto">
                                    <a href="#">
                                        <span><img src="assets/images/logo-dark.png" alt="" height="77"></span>
                                    </a>
                                    <p class="text-muted mb-4 mt-3">@lang('auth.desc')</p>
                                </div>

                                <form method="post" action="{{route('auth')}}">
                                    @csrf
                                    @if(!empty($error))
                                        <div class="alert alert-danger">
                                            @lang('auth.errorLogin')
                                        </div>
                                    @endif

                                    <div class="form-group mb-3">
                                        <label for="emailaddress">@lang('auth.email')</label>
                                        <input class="form-control" name="login" type="email" id="emailaddress" required=""
                                               placeholder="@lang('auth.email_enter')">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">@lang('auth.password')</label>
                                        <input class="form-control" name="password" type="password" required="" id="password"
                                               placeholder="@lang('auth.password_enter')">
                                    </div>


                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block"
                                                type="submit"> @lang('auth.auth') </button>
                                    </div>

                                </form>


                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                    {{--                        <div class="row mt-3">--}}
                    {{--                            <div class="col-12 text-center">--}}
                    {{--                                <p> <a href="pages-recoverpw" class="text-white-50 ml-1">Forgot your password?</a></p>--}}
                    {{--                            </div> <!-- end col -->--}}
                    {{--                        </div>--}}
                    <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


        <footer class="footer footer-alt">
            {{date('Y')}} &copy; V.E.R. Group
        </footer>
@endsection
