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
                            @if($filters)
                                <div class="col-lg-1">
                                    <a href="{{route('stock.index')}}">
                                        <button type="button"
                                                class="btn btn-danger waves-effect waves-light"><i
                                                    class="mdi mdi-close"></i></button>
                                    </a>
                                </div>
                            @endif
                            <div class="@if($filters) col-lg-7 @else col-lg-8 @endif">
                                <form id="form" method="GET" action="{{route('stock.index')}}">
                                    <div class="row">
                                        <div class="form-group mb-2 col-lg-3">
                                            <select id="searchName"
                                                    data-searching="@lang('stock.search.searching')"
                                                    data-no-results="@lang('stock.search.noResults')"
                                                    data-start="@lang('stock.search.start')"
                                                    data-placeholder="@lang('stock.search.searchName')"
                                                    data-url="{{route('request.getStocks',['specific' => 'name',$path])}}"
                                                    name="name"
                                                    class="form-control">
                                                @if(!empty($searchName))
                                                    <option value="{{$searchName}}"
                                                            selected>{{$searchName}}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group mb-2 col-lg-3">
                                            <select id="searchDate"
                                                    data-searching="@lang('stock.search.searching')"
                                                    data-no-results="@lang('stock.search.noResults')"
                                                    data-start="@lang('stock.search.start')"
                                                    data-placeholder="@lang('stock.search.searchDate')"
                                                    data-url="{{route('request.getStocks',['specific' => 'date',$path])}}"
                                                    name="date"
                                                    class="form-control">
                                                @if(!empty($searchDate))
                                                    <option value="{{$searchDate}}"
                                                            selected>{{$searchDate}}</option>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group mb-2 col-lg-3">
                                            <select id="searchOwner"
                                                    data-searching="@lang('stock.search.searching')"
                                                    data-no-results="@lang('stock.search.noResults')"
                                                    data-start="@lang('stock.search.start')"
                                                    data-placeholder="@lang('stock.search.searchOwner')"
                                                    data-url="{{route('request.getStockOwner',[$path])}}"
                                                    name="owner"
                                                    class="form-control">
                                                @if(!empty($searchOwner))
                                                    <option value="{{$searchOwner->id}}"
                                                            selected>{{$searchOwner->fullname()}}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4">
                                <div class="text-lg-right">
                                    @can('policy','guard_stock_add')
                                        <a href="{{route('stock.create')}}">
                                            <button type="button"
                                                    class="btn btn-danger waves-effect waves-light mb-2 mr-2">
                                                <i
                                                        class="mdi mdi-basket mr-1"></i> @lang('stock.create')
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
                        @include('panel.stock._table',['data'=>$data])
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
    <script src="{{ URL::asset('assets/js/pages/stock.init.js')}}"></script>
@endsection