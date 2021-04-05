@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
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
                                <form id="form" method="GET" action="{{route('issuanceOfFinance.index')}}">
                                    <div class="row">
                                        @if($filters)
                                            <div class="col-lg-1">
                                                <a href="{{route('issuanceOfFinance.index')}}">
                                                    <button type="button"
                                                            class="btn btn-danger waves-effect waves-light"><i
                                                                class="mdi mdi-close"></i></button>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="form-group mb-2 @if($filters) col-lg-3 @else col-lg-4 @endif">
                                            <select id="searchName"
                                                    data-searching="@lang('issuanceOfFinance.search.searching')"
                                                    data-no-results="@lang('issuanceOfFinance.search.noResults')"
                                                    data-start="@lang('issuanceOfFinance.search.start')"
                                                    data-placeholder="@lang('issuanceOfFinance.search.searchName')"
                                                    data-url="{{route('request.getIssuance',['specific' => 'name',$path])}}"
                                                    name="name"
                                                    class="form-control">
                                                @if(!empty($searchName))
                                                    <option value="{{$searchName}}"
                                                            selected>{{$searchName}}</option>
                                                @endif
                                            </select>

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4">
                                <div class="text-lg-right">
                                    @can('policy','guard_issuance_of_finance_add')
                                        <a href="{{route('issuanceOfFinance.create')}}">
                                            <button type="button"
                                                    class="btn btn-danger waves-effect waves-light mb-2 mr-2">
                                                <i
                                                        class="mdi mdi-basket mr-1"></i> @lang('issuanceOfFinance.create')
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
                        @include('panel.issuanceOfFinance._table',['data'=>$data])
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
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/purchase.init.js')}}"></script>
@endsection