@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/fancybox/fancybox.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')

    <!-- Start Content-->
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-lg-8">
                                <form id="form" method="GET" action="{{route('company.index')}}">
                                    <div class="row">
                                        @if($filters)
                                            <div class="col-lg-1">
                                                <a href="{{route('company.index')}}">
                                                    <button type="button"
                                                            class="btn btn-danger waves-effect waves-light"><i
                                                                class="mdi mdi-close"></i></button>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="form-group mb-2 @if($filters)col-lg-3 @else col-lg-4 @endif">
                                            <select id="searchName"
                                                    data-searching="@lang('company.search.searching')"
                                                    data-no-results="@lang('company.search.noResults')"
                                                    data-start="@lang('company.search.start')"
                                                    data-placeholder="@lang('company.search.searchName')"
                                                    data-url="{{route('request.getCompanies',['specific' => 'name',$path])}}"
                                                    name="name"
                                                    class="form-control">
                                                @if(!empty($searchName))
                                                    <option value="{{$searchName}}"
                                                            selected>{{$searchName}}</option>
                                                @endif
                                            </select>

                                        </div>

                                        <div class="form-group mb-2 col-lg-4">
                                            <select id="searchPhone"
                                                    class="form-control"
                                                    data-searching="@lang('company.search.searching')"
                                                    data-no-results="@lang('company.search.noResults')"
                                                    data-start="@lang('company.search.start')"
                                                    data-placeholder="@lang('company.search.searchPhone')"
                                                    data-url="{{route('request.getCompanies',['specific' => 'phone',$path])}}"
                                                    name="phone">
                                                @if(!empty($searchPhone))
                                                    <option value="{{$searchPhone}}"
                                                            selected>{{$searchPhone}}</option>
                                                @endif
                                            </select>

                                        </div>

                                        <div class="form-group mb-2 col-lg-4">
                                            <select id="searchEmail"
                                                    class="form-control"
                                                    data-searching="@lang('company.search.searching')"
                                                    data-no-results="@lang('company.search.noResults')"
                                                    data-start="@lang('company.search.start')"
                                                    data-placeholder="@lang('company.search.searchEmail')"
                                                    data-url="{{route('request.getCompanies',['specific' => 'email',$path])}}"
                                                    name="email">
                                                @if(!empty($searchEmail))
                                                    <option value="{{$searchEmail}}"
                                                            selected>{{$searchEmail}}</option>
                                                @endif
                                            </select>

                                        </div>

                                        <div class="form-group mb-2 col-lg-4">
                                            <select id="searchSite"
                                                    class="form-control"
                                                    data-searching="@lang('company.search.searching')"
                                                    data-no-results="@lang('company.search.noResults')"
                                                    data-start="@lang('company.search.start')"
                                                    data-placeholder="@lang('company.search.searchSite')"
                                                    data-url="{{route('request.getCompanies',['specific' => 'website',$path])}}"
                                                    name="website">
                                                @if(!empty($searchSite))
                                                    <option value="{{$searchSite}}"
                                                            selected>{{$searchSite}}</option>
                                                @endif
                                            </select>

                                        </div>

                                        <div class="form-group mb-2 col-lg-4">
                                            <select id="searchBilling"
                                                    class="form-control"
                                                    data-searching="@lang('company.search.searching')"
                                                    data-no-results="@lang('company.search.noResults')"
                                                    data-start="@lang('company.search.start')"
                                                    data-placeholder="@lang('company.search.searchBilling')"
                                                    data-url="{{route('request.getCompanies',['specific' => 'billing_address',$path])}}"
                                                    name="billing_address">
                                                @if(!empty($searchBilling))
                                                    <option value="{{$searchBilling}}"
                                                            selected>{{$searchBilling}}</option>
                                                @endif
                                            </select>

                                        </div>

                                        <div class="form-group mb-2 col-lg-4">
                                            <select id="searchPayment"
                                                    class="form-control"
                                                    data-searching="@lang('company.search.searching')"
                                                    data-no-results="@lang('company.search.noResults')"
                                                    data-start="@lang('company.search.start')"
                                                    data-placeholder="@lang('company.search.searchPayment')"
                                                    data-url="{{route('request.getCompanies',['specific' => 'payment_info', $path])}}"
                                                    name="payment_info">
                                                @if(!empty($searchPayment))
                                                    <option value="{{$searchPayment}}"
                                                            selected>{{$searchPayment}}</option>
                                                @endif
                                            </select>

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4">
                                <div class="text-lg-right">
                                    @can('policy','guard_company_add')
                                        <a href="{{route('company.create')}}">
                                            <button type="button"
                                                    class="btn btn-danger waves-effect waves-light mb-2 mr-2">
                                                <i
                                                        class="mdi mdi-basket mr-1"></i> @lang('company.create')
                                            </button>
                                        </a>
                                    @endcan
                                    {{--                                    <button type="button" class="btn btn-light waves-effect mb-2">Export</button>--}}
                                </div>
                            </div><!-- end col-->
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                        @include('panel.companies._table',['data'=>$data])
                        {{$data->links()}}
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/fancybox/fancybox.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/company.init.js')}}"></script>
@endsection
