@extends('layouts.master')
@section('css')
@endsection
@section('content')
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @lang('lots.main-info')
                    </div>
                    <div class="card-body">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-18"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a href="{{route('lots.edit',$item->id)}}" class="dropdown-item">
                                    <i class="mdi mdi-pencil-outline mr-1"></i>Edit
                                </a>
                                <div class="dropdown-divider"></div>
                                <!-- item-->
                                <a href="{{route('lots.delete',$item->id)}}"
                                   onclick="return confirm('{{__('index.confirmation')}}');"
                                   class="dropdown-item text-danger">
                                    <i class="mdi mdi-delete-outline mr-1"></i>Delete
                                </a>
                            </div> <!-- end dropdown menu-->
                        </div> <!-- end dropdown-->
                        <div class="clearfix"></div>

                        <h4><b>{{$item->name}}</b></h4>

                        <div class="row">
                            <div class="col-md-4">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('lots.moderator')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{($item->owner) ? $item->owner->fullname() : 'Неизвестно'}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->

                            <div class="col-md-4">
                                <!-- start due date -->
                                <p class="mt-2 mb-1 text-muted">@lang('lots.company')</p>
                                <div class="media">
                                    <i class="mdi mdi-briefcase-check-outline font-18 text-success mr-1"></i>
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{($item->company) ? $item->company->name : 'Неизвестно'}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end due date -->
                            </div>


                            <div class="col-md-4">
                                <!-- start due date -->
                                <p class="mt-2 mb-1 text-muted">@lang('lots.purchase')</p>
                                <div class="media">
                                    <i class="mdi mdi-briefcase-check-outline font-18 text-success mr-1"></i>
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            @if($inPurchase)
                                               <b class="text-danger">@lang('lots.inPurchase')</b>
                                            @else
                                                @lang('lots.NotInPurchase')
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                                <!-- end due date -->
                            </div>
                        </div> <!-- end row -->


                        <h5 class="mt-3">@lang('lots.description'):</h5>

                        <p class="text-muted mb-4">
                            {{$item->description??'Описания нет'}}
                        </p>

                    </div> <!-- end card-body-->


                </div>
                <div class="card">
                    <div class="card-header">
                        @lang('lots.rate&weight')
                    </div>
                    <div class="card-body">
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('lots.pt')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->pt_weight}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->

                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('lots.r_pt')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->pt_rate}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->

                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('lots.s_pt')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{($item->pt_weight*$item->pt_rate)}} €
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->

                            <div class="col-md-4">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('lots.pd')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->pd_weight}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->

                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('lots.r_pd')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->pd_rate}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->

                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('lots.s_pd')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{($item->pd_weight*$item->pd_rate)}} €
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->

                            <div class="col-md-4">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('lots.rh')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->rh_weight}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->

                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('lots.r_rh')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->rh_rate}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->

                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('lots.s_rh')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{($item->rh_weight*$item->rh_rate)}} €
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        <div class="row justify-content-between">
                            <div class="col-md-4">
                                <p class="mt-2 mb-1 text-muted">@lang('lots.created_at')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{($item->created_at)}}
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <p class="mt-2 mb-1 text-muted">@lang('lots.summ')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{($item->pt_weight*$item->pt_rate)+($item->pd_weight*$item->pd_rate)+($item->rh_weight*$item->rh_rate)}} €
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card-body-->




                </div> <!-- end col-->
            </div><!-- end col-->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        История изменений
                    </div>
                    <div class="card-body">
                        <div class="border-bottom pt-2 pb-2">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet aspernatur eius est ipsam
                            iure quidem quisquam quos similique tempore vero. Animi at enim ipsam labore molestias neque
                            quia ratione sit?
                        </div>
                        <div class="border-bottom mt-1 pt-2 pb-2">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet aspernatur eius est ipsam
                            iure quidem quisquam quos similique tempore vero. Animi at enim ipsam labore molestias neque
                            quia ratione sit?
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row-->

        </div> <!-- container -->

    </div>

@endsection
