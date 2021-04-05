@extends('layouts.master')
@section('css')
    <!-- Plugins css -->
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
                        <div class="row mb-2 align-items-center">
                            <div class="col-lg-8 row align-items-center">

                                <form id="form" method="get" action="{{route('catalog.index')}}" class="col-lg-9">
                                    <div class="row">
                                        @if($filters)
                                            <div class="col-lg-1">
                                                <a href="{{route('catalog.index')}}">
                                                    <button type="button"
                                                            class="btn btn-danger waves-effect waves-light"><i
                                                                class="mdi mdi-close"></i></button>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="form-group mb-2 @if($filters) col-lg-3 @else col-lg-4 @endif">
                                            <div>
                                                <select id="search_brand_id"
                                                        class="form-control @error('search_for_catalog') is-invalid @enderror "
                                                        name="search_brand_id"
                                                        data-searching="@lang('catalog.search.searching')"
                                                        data-no-results="@lang('catalog.search.noResults')"
                                                        data-start="@lang('catalog.search.start')"
                                                        data-placeholder="@lang('catalog.search_car_brand')"
                                                        data-toggle="select2">
                                                    @if(!$brand_search)
                                                        <option selected value=""
                                                                disabled>@lang('catalog.search.categories')</option>
                                                    @endif
                                                    @foreach($brands as $brand)
                                                        <option @if($brand_search === $brand['id']) selected
                                                                @endif value="{{$brand['id']}}">{{$brand['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-group mb-2 col-lg-4">
                                            <div>
                                                <select id="search_for_catalog"
                                                        class="form-control @error('search_for_catalog') is-invalid @enderror "
                                                        name="search_for_catalog"
                                                        data-searching="@lang('catalog.search.searching')"
                                                        data-no-results="@lang('catalog.search.noResults')"
                                                        data-start="@lang('catalog.search.start')"
                                                        data-placeholder="@lang('catalog.search_serial_number')"
                                                        data-url="{{route('request.getSerialNumber', ($brand_search) ? ['car_brand' => $brand_search] : [])}}">
                                                    @if($search)
                                                        <option value="{{$search}}" selected>{{$search}}</option>
                                                    @endif
                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-group mb-2 col-lg-4">
                                            <div>
                                                <select id="lots"
                                                        class="form-control @error('fix_lot') is-invalid @enderror "
                                                        data-info="{{route('request.getLot')}}"
                                                        data-searching="@lang('purchase.search.searching')"
                                                        data-no-results="@lang('purchase.search.noResults')"
                                                        data-start="@lang('purchase.search.start')"
                                                        data-placeholder="@lang('catalog.search_lots')"
                                                        data-url="{{route('request.getLots')}}"
                                                        id="lots" name="lot"
                                                        class="@error('lot') is-invalid @enderror form-control">
                                                    @if(!empty($lot->id))
                                                        <option value="{{$lot->id}}"
                                                                selected>{{$lot->name.' | '.$lot->company->name}}</option>
                                                    @endif
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-pink waves-effect waves-light mb-2 mr-2"
                                            data-toggle="modal" data-target="#course-settings">
                                        <i
                                                class="mdi mdi-basket mr-1"></i> @lang('catalog.course_settings.name')
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-4 @if(!empty($lot->id)) row  @endif">
                                @can('policy','guard_catalog_write')
                                    <div class="text-lg-right   @if(!empty($lot->id))col-lg-6 @endif">
                                        <a href="{{route('catalog.create')}}">
                                            <button type="button"
                                                    class="btn btn-danger waves-effect waves-light mb-2 mr-2">
                                                <i
                                                        class="mdi mdi-basket mr-1"></i> @lang('catalog.create')
                                            </button>
                                        </a>
                                        {{--                                    <button type="button" class="btn btn-light waves-effect mb-2">Export</button>--}}
                                    </div>
                                @endcan
                                @can('policy','guard_purchase_add')
                                    @if(!empty($lot->id))
                                        <div class="text-lg-right col-lg-6 ">
                                            <a class="cart-save" data-url="{{route('purchase.create')}}" href="#">
                                                <button type="button" class="btn btn-primary waves-effect waves-light">
                                                    <i
                                                            class="mdi mdi-basket mr-1"></i> @lang('catalog.cart')
                                                </button>
                                            </a>
                                            {{--                                    <button type="button" class="btn btn-light waves-effect mb-2">Export</button>--}}
                                        </div>
                                    @endif
                                @endcan


                            </div><!-- end col-->
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                        @if($checkCustomDiscount)
                            <div class="alert alert-warning">@lang('catalog.customDiscount')</div>
                        @endif
                        <div class="col-xl-12 m-auto row">
                            <div class="col-xl-3">Курсы:</div>
                            <div class="col-xl-3">PT:
                                @if(!empty($lot->id))
                                    {{$lot->pt_rate}}
                                @else
                                    {{session('pt') ?? 100}}
                                @endif</div>

                            <div class="col-xl-3">PD
                                @if(!empty($lot->id))
                                    {{$lot->pd_rate}}
                                @else
                                    {{session('pd') ?? 100}}
                                @endif</div>
                            <div class="col-xl-3">RH:
                                @if(!empty($lot->id))
                                    {{$lot->rh_rate}}
                                @else
                                    {{session('rh') ?? 100}}
                                @endif</div>
                        </div>
                        <hr>
                        <form id="form-2" method="post">
                            @csrf
                            @include('panel.catalogs._table',['data'=>$data,'lot'=>$lot])
                        </form>

                        {{$data->withQueryString()->links()}}
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
    @include('panel.catalogs.modal')
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/dropify/dropify.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/catalog.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/fancybox/fancybox.min.js')}}"></script>
@endsection
