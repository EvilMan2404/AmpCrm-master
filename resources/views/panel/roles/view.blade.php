@extends('layouts.master')
@section('css')
@endsection
@section('content')
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @lang('roles.main-info')
                    </div>
                    <div class="card-body">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-18"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a href="{{route('roles.edit',$item->id)}}" class="dropdown-item">
                                    <i class="mdi mdi-pencil-outline mr-1"></i>Edit
                                </a>
                                <div class="dropdown-divider"></div>
                                <!-- item-->
                                <a href="{{route('roles.delete',$item->id)}}"
                                   onclick="return confirm('{{__('index.confirmation')}}');"
                                   class="dropdown-item text-danger">
                                    <i class="mdi mdi-delete-outline mr-1"></i>Delete
                                </a>
                            </div> <!-- end dropdown menu-->
                        </div> <!-- end dropdown-->

                        <h4><b>{{$item->name}}</b></h4>

                        <div class="row">
                            <div class="col-md-3">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('roles.id')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->id ?? __('stock.empty')}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->
                            <div class="col-md-3">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('roles.name')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->name}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->

                            <div class="col-md-3">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('roles.guard_name')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->guard_name ?? __('roles.empty')}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div> <!-- end card-body-->


                </div>
            </div><!-- end col-->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @lang('roles.permissions')
                    </div>
                    <div class="card-body">
                        <div class="clearfix"></div>
                        <div class="media">
                            <div class="media-body">
                                <div class="row">
                                    @if($item->permissions)
                                        @foreach($item->permissions as $permission)
                                            @if($permission->permission)
                                                <div class="col-xl-2">
                                                    <h5 class="mt-1 font-size-14">
                                                        <a class="text-info"
                                                           href="{{route('permissions.index',['name' => $permission->permission->name])}}">{{$permission->permission->name}}
                                                        </a>
                                                        <button class="btn p-0"
                                                                title="{{$permission->permission->desc}}"
                                                                data-plugin="tippy" data-tippy-placement="top">
                                                            <i class="fas fas fa-question-circle"></i>
                                                        </button>
                                                    </h5>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        @lang('roles.no_permissions')
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card-body-->


                </div> <!-- end col-->
            </div>
            <!-- end row-->

        </div> <!-- container -->

    </div>

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/tippy-js/tippy-js.min.js')}}"></script>
@endsection