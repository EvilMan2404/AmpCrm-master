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
                                <form id="form" method="GET" action="{{route('users.index')}}">
                                    <div class="row">
                                        <div class="form-group mb-2 col-lg-3">
                                            <select id="searchName"
                                                    data-searching="@lang('users.search.searching')"
                                                    data-no-results="@lang('users.search.noResults')"
                                                    data-start="@lang('users.search.start')"
                                                    data-placeholder="@lang('users.search.searchName')"
                                                    data-url="{{route('request.getUsers',['specific' => 'fullname',$path])}}"
                                                    name="name"
                                                    class="form-control">
                                                @if(!empty($searchName))
                                                    <option value="{{$searchName}}"
                                                            selected>{{$searchName}}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group mb-2 col-lg-3">
                                            <select id="searchEmail"
                                                    data-searching="@lang('users.search.searching')"
                                                    data-no-results="@lang('users.search.noResults')"
                                                    data-start="@lang('users.search.start')"
                                                    data-placeholder="@lang('users.search.searchEmail')"
                                                    data-url="{{route('request.getUsers',['specific' => 'email',$path])}}"
                                                    name="email"
                                                    class="form-control">
                                                @if(!empty($searchEmail))
                                                    <option value="{{$searchEmail}}"
                                                            selected>{{$searchEmail}}</option>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group mb-2 col-lg-3">
                                            <select id="searchPhone"
                                                    data-searching="@lang('users.search.searching')"
                                                    data-no-results="@lang('users.search.noResults')"
                                                    data-start="@lang('users.search.start')"
                                                    data-placeholder="@lang('users.search.searchPhone')"
                                                    data-url="{{route('request.getUsers',['specific' => 'phone',$path])}}"
                                                    name="phone"
                                                    class="form-control">
                                                @if(!empty($searchPhone))
                                                    <option value="{{$searchPhone}}"
                                                            selected>{{$searchPhone}}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4">
                                <div class="text-lg-right">
                                    @can('policy','guard_users_add')
                                        <a href="{{route('users.create')}}">
                                            <button type="button"
                                                    class="btn btn-danger waves-effect waves-light mb-2 mr-2">
                                                <i
                                                        class="mdi mdi-basket mr-1"></i> @lang('users.create')
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
                        @include('panel.users._table',['data'=>$data])
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
    <script src="{{ URL::asset('assets/js/pages/users.init.js')}}"></script>
@endsection