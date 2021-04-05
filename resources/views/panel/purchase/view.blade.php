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
                        @lang('purchase.main-info')
                    </div>
                    <div class="card-body">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-18"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a href="{{route('purchase.edit',$item->id)}}" class="dropdown-item">
                                    <i class="mdi mdi-pencil-outline mr-1"></i>Edit
                                </a>
                                <div class="dropdown-divider"></div>
                                <!-- item-->
                                <a href="{{route('purchase.delete',$item->id)}}"
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
                                <p class="mt-2 mb-1 text-muted">@lang('purchase.lots')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            @if(!empty($lotInfo->id))
                                                <a href="{{route('lots.info',$lotInfo->id)}}">{{$lotInfo->name}}</a>
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->

                            <div class="col-md-4">
                                <!-- start due date -->
                                <p class="mt-2 mb-1 text-muted">@lang('purchase.categories')</p>
                                <div class="media">
                                    <i class="mdi mdi-briefcase-check-outline font-18 text-success"></i>
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            <ul>
                                                @foreach($catalogInfo as $key=>$value)
                                                    <li><a href="{{route('catalog.info',$value->id)}}">{{$value->name}}
                                                            | {{$value->carIdRelation->name}}
                                                            | {{$value->serial_number}}</a></li>
                                                @endforeach
                                            </ul>
                                        </h5>
                                    </div>
                                </div>
                                <!-- end due date -->
                            </div>
                        </div> <!-- end row -->


                        <h5 class="mt-3">@lang('purchase.description'):</h5>

                        <p class="text-muted mb-4">
                            {{$item->description??'Описания нет'}}
                        </p>

                    </div> <!-- end card-body-->


                </div>
                <div class="card">
                    <div class="card-header">
                        @lang('purchase.details')
                    </div>
                    <div class="card-body">
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Date View -->
                                <div class="table-responsive">
                                    <table id="table"
                                           class="table table-borderless mb-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>PT</th>
                                            <th>PD</th>
                                            <th>RH</th>
                                            <th>@lang('purchase.table.total_weight')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>

                                            <td class="pt_calc">{{$item->pt}}</td>
                                            <td class="pd_calc">{{$item->pd}}</td>
                                            <td class="rh_calc">{{$item->rh}}</td>
                                            <td class="wgkg_calc">{{$item->weight}}</td>
                                        </tr>
                                        <tr class="table-info">

                                            <td class="font-weight-bold">@lang('purchase.table.total_price')</td>
                                            <td colspan="3" class="total_calc font-weight-bold">{{$item->total}}</td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <!-- Date View -->

                            </div>

                            <div class="col-lg-6">
                                <!-- Date View -->

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
