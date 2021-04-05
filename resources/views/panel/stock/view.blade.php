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
                        @lang('stock.main-info')
                    </div>
                    <div class="card-body">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-18"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a href="{{route('stock.edit',$item->id)}}" class="dropdown-item">
                                    <i class="mdi mdi-pencil-outline mr-1"></i>Edit
                                </a>
                                <div class="dropdown-divider"></div>
                                <!-- item-->
                                <a href="{{route('stock.delete',$item->id)}}"
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
                                <p class="mt-2 mb-1 text-muted">@lang('stock.id')</p>
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
                                <p class="mt-2 mb-1 text-muted">@lang('stock.user_id')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{($item->userRelation) ? $item->userRelation->fullname() : __('stock.empty')}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->

                            <div class="col-md-3">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('stock.date')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->date ?? __('stock.empty')}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div> <!-- end card-body-->


                </div>
            </div><!-- end col-->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        @lang('stock.analysis')
                    </div>
                    <div class="card-body">
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('stock.ceramic')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->weight_ceramics}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->
                            <div class="col-md-4">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('stock.ceramic_analysis_pt')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->analysis_pt}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->

                            <div class="col-md-4">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('stock.ceramic_analysis_pd')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->analysis_pd}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->

                            <div class="col-md-4">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('stock.ceramic_analysis_rh')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->analysis_rh}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div> <!-- end card-body-->


                </div> <!-- end col-->
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        @lang('stock.analysis')
                    </div>
                    <div class="card-body">
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('stock.dust')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->weight_dust}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->
                            <div class="col-md-4">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('stock.dust_analysis_pt')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->analysis_dust_pt}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->

                            <div class="col-md-4">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('stock.dust_analysis_pd')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->analysis_dust_pd}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->

                            <div class="col-md-4">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('stock.dust_analysis_rh')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->analysis_dust_rh}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div> <!-- end card-body-->


                </div> <!-- end col-->
            </div>


            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-4">
                                <p class="mt-2 mb-1 text-muted">@lang('stock.metallic')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{($item->metallic)}} €
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <p class="mt-2 mb-1 text-muted">@lang('stock.catalyst')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->catalyst}}
                                        </h5>
                                    </div>
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
