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
                                <form id="form" method="GET" action="{{route('lots.index')}}">
                                    <div class="row">
                                        @if($filters)
                                            <div class="col-lg-1">
                                                <a href="{{route('lots.index')}}">
                                                    <button type="button"
                                                            class="btn btn-danger waves-effect waves-light"><i
                                                                class="mdi mdi-close"></i></button>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="form-group mb-2 @if($filters) col-lg-2 @else col-lg-3 @endif">
                                            <select id="searchName"
                                                    data-searching="@lang('lots.search.searching')"
                                                    data-no-results="@lang('lots.search.noResults')"
                                                    data-start="@lang('lots.search.start')"
                                                    data-placeholder="@lang('lots.search.searchName')"
                                                    data-url="{{route('request.getLots',['specific' => 'name',$path])}}"
                                                    name="name"
                                                    class="form-control">
                                                @if(!empty($searchName))
                                                    <option value="{{$searchName}}"
                                                            selected>{{$searchName}}</option>
                                                @endif
                                            </select>

                                        </div>

                                        <div class="form-group mb-2 col-lg-3">
                                            <select id="searchCompany"
                                                    data-searching="@lang('lots.search.searching')"
                                                    data-no-results="@lang('lots.search.noResults')"
                                                    data-start="@lang('lots.search.start')"
                                                    data-placeholder="@lang('lots.search.searchCompany')"
                                                    data-url="{{route('request.getCompanyLots',[$path])}}"
                                                    name="company"
                                                    class="form-control">
                                                @if(!empty($searchCompany))
                                                    <option value="{{$searchCompany->id}}"
                                                            selected>{{$searchCompany->name}}</option>
                                                @endif
                                            </select>

                                        </div>

                                        <div class="form-group mb-2 col-lg-3">
                                            <select id="searchAssigned"
                                                    data-searching="@lang('lots.search.searching')"
                                                    data-no-results="@lang('lots.search.noResults')"
                                                    data-start="@lang('lots.search.start')"
                                                    data-placeholder="@lang('lots.search.searchAssigned')"
                                                    data-url="{{route('request.getLotsAssigned',[$path])}}"
                                                    name="assigned"
                                                    class="form-control">
                                                @if(!empty($searchAssigned))
                                                    <option value="{{$searchAssigned->id}}"
                                                            selected>{{$searchAssigned->fullname()}}</option>
                                                @endif
                                            </select>

                                        </div>
                                        <div class="form-group mb-2 col-lg-3">
                                            <select id="searchOwner"
                                                    data-searching="@lang('lots.search.searching')"
                                                    data-no-results="@lang('lots.search.noResults')"
                                                    data-start="@lang('lots.search.start')"
                                                    data-placeholder="@lang('lots.search.searchOwner')"
                                                    data-url="{{route('request.getLotsOwner',[$path])}}"
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
                                    @can('policy','guard_lots_add')
                                        <a href="{{route('lots.create')}}">
                                            <button type="button"
                                                    class="btn btn-danger waves-effect waves-light mb-2 mr-2">
                                                <i
                                                        class="mdi mdi-basket mr-1"></i> @lang('lots.create')
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
                        @include('panel.lots._table',['data'=>$data])
                        {{$data->links()}}
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/lots.init.js')}}"></script>
@endsection
