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
                                <form id="form" method="GET" action="{{route('clientGroupType.index')}}">
                                    <div class="row">
                                        <div class="form-group mb-2 col-lg-4">
                                            <select id="searchName"
                                                    data-searching="@lang('clientGroupType.search.searching')"
                                                    data-no-results="@lang('clientGroupType.search.noResults')"
                                                    data-start="@lang('clientGroupType.search.start')"
                                                    data-placeholder="@lang('clientGroupType.search.searchName')"
                                                    data-url="{{route('request.getClientTypeGroups',['specific' => 'title',$path])}}"
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
                            </div><!-- end col-->
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                        @include('panel.clientGroupType._table',['data'=>$data])
                        {{$data->links()}}
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
            @can('policy','guard_client_group_type_edit')
                @include('panel.clientGroupType.form')
            @endcan
        </div>
        <!-- end row -->

    </div> <!-- container -->

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/common.init.js')}}"></script>
@endsection