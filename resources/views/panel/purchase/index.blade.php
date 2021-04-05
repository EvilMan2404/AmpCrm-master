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
                            <div class="col-lg-6">
                                <form id="form" method="GET" action="{{route('purchase.index')}}">
                                    <div class="row">
                                        @if($filters)
                                            <div class="col-lg-1">
                                                <a id="clearFilters" href="{{route('purchase.index')}}">
                                                    <button type="button"
                                                            class="btn btn-danger waves-effect waves-light"><i
                                                                class="mdi mdi-close"></i></button>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="form-group mb-2 @if($filters) col-lg-2 @else col-lg-3 @endif">
                                            <select id="searchName"
                                                    data-searching="@lang('purchase.search.searching')"
                                                    data-no-results="@lang('purchase.search.noResults')"
                                                    data-start="@lang('purchase.search.start')"
                                                    data-placeholder="@lang('purchase.search.searchName')"
                                                    data-url="{{route('request.searchPurchase',['specific' => 'name',$path])}}"
                                                    name="name"
                                                    class="form-control">
                                                @if(!empty($searchName))
                                                    <option value="{{$searchName}}"
                                                            selected>{{$searchName}}</option>
                                                @endif
                                            </select>

                                        </div>


                                        <div class="form-group mb-2 col-lg-3">

                                            <select id="searchStatus"
                                                    data-searching="@lang('purchase.search.searching')"
                                                    data-no-results="@lang('purchase.search.noResults')"
                                                    data-start="@lang('purchase.search.start')"
                                                    data-placeholder="@lang('purchase.search.searchStatus')"
                                                    data-url="{{route('request.searchPurchase',['specific' => 'name',$path])}}"
                                                    name="status"
                                                    class="form-control">
                                                <option value="">@lang('purchase.search.chooseStatus')</option>
                                                @foreach($statuses as $status)
                                                    <option @if($searchStatus === $status->id) selected
                                                            @endif value="{{$status->id}}">{{$status->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group mb-2 col-lg-3">
                                            <select id="searchOwner"
                                                    data-searching="@lang('purchase.search.searching')"
                                                    data-no-results="@lang('purchase.search.noResults')"
                                                    data-start="@lang('purchase.search.start')"
                                                    data-placeholder="@lang('purchase.search.searchOwner')"
                                                    data-url="{{route('request.getPurchaseOwner',[$path])}}"
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


                            @can('policy','guard_stock_add')
                                <div class="text-lg-right col-lg-3">
                                    <a class="cart-save" data-url="{{route('stock.create')}}" href="#">
                                        <button type="button" class="btn btn-primary waves-effect waves-light">
                                            <i
                                                    class="mdi mdi-basket mr-1"></i> @lang('purchase.createLotStock')
                                        </button>
                                    </a>
                                    {{--                                    <button type="button" class="btn btn-light waves-effect mb-2">Export</button>--}}
                                </div>
                            @endcan
                            <div class="col-lg-3">
                                <div class="text-lg-right">
                                    @can('policy','guard_purchase_add')
                                        <a href="{{route('purchase.create')}}">
                                            <button type="button"
                                                    class="btn btn-danger waves-effect waves-light mb-2 mr-2">
                                                <i
                                                        class="mdi mdi-basket mr-1"></i> @lang('purchase.create')
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
                        @include('panel.purchase._table',['data'=>$data])
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