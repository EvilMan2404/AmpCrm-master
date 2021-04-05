@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')

    <!-- Start Content-->
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-lg-8">
                                <form id="form" method="GET" action="{{route('permissions.index')}}">
                                    <div class="row">
                                        @if($filters)
                                            <div class="col-lg-2">
                                                <a href="{{route('permissions.index')}}">
                                                    <button type="button"
                                                            class="btn btn-danger waves-effect waves-light"><i
                                                                class="mdi mdi-close"></i></button>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="form-group mb-2 @if($filters) col-lg-5 @else col-lg-6 @endif">
                                            <select id="searchName"
                                                    data-searching="@lang('permissions.search.searching')"
                                                    data-no-results="@lang('permissions.search.noResults')"
                                                    data-start="@lang('permissions.search.start')"
                                                    data-placeholder="@lang('permissions.search.searchName')"
                                                    data-url="{{route('request.getPermissions',['type' => 'multi',$path])}}"
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
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                        @include('panel.permissions._table',['data'=>$data])
                        {{$data->links()}}
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
            @can('policy','guard_permissions_edit')
                @include('panel.permissions.form')
            @endcan
        </div>
        <!-- end row -->

    </div> <!-- container -->

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/tippy-js/tippy-js.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/common.init.js')}}"></script>
@endsection