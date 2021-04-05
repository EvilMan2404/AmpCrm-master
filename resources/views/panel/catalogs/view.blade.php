@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/fancybox/fancybox.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)
        @if($checkCustomDiscount)
            <div class="alert alert-warning">@lang('catalog.customDiscount')</div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-lg-5">

                            <div class="tab-content pt-0">
                                @foreach($item->files as $key=>$file)
                                    <div class="tab-pane @if($key === 0) show active @endif"
                                         id="product-{{$key}}-item">
                                        <a href="/images/{{$file->file}}" data-fancybox="gallery-{{$item->id}}"
                                           data-caption="{{$file->name}}">
                                            <img src="/images/{{$file->file}}" alt="{{$file->name}}"
                                                 class="img-fluid mx-auto d-block rounded">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            @if(count($item->files)>1)
                                <ul class="nav nav-pills nav-justified">
                                    @foreach($item->files as $key=>$file)
                                        <li class="nav-item">
                                            <a href="#product-{{$key}}-item" data-toggle="tab" aria-expanded="false"
                                               class="nav-link product-thumb @if($key === 0) active show @endif">
                                                <img src="/images/{{$file->file}}" alt="{{$file->name}}"
                                                     class="img-fluid mx-auto d-block rounded">
                                            </a>
                                        </li>

                                    @endforeach
                                </ul>
                            @endif
                        </div> <!-- end col -->
                        <div class="col-lg-7">
                            <div class="pl-xl-3 mt-3 mt-xl-0">
                                <a href="#"
                                   class="text-primary">@if($item->carIdRelation){{$item->carIdRelation->name}}@endif</a>
                                <h4 class="mb-3">{{$item->name}}</h4>

                                <p class="text-muted mb-4">{{$item->description}}</p>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div>
                                            <p class="text-muted"><i
                                                        class="mdi mdi-checkbox-marked-circle-outline h6 text-primary mr-2"></i>
                                                @lang('catalog.serial_number') : <b>{{$item->serial_number}}</b>
                                            </p>
                                            @if($item->carIdRelation)
                                                <p class="text-muted"><i
                                                            class="mdi mdi-checkbox-marked-circle-outline h6 text-primary mr-2"></i>
                                                    @lang('catalog.car_brand') : <b>{{$item->carIdRelation->name}}</b>
                                                </p>
                                            @endif
                                            <p class="text-muted"><i
                                                        class="mdi mdi-checkbox-marked-circle-outline h6 text-primary mr-2"></i>
                                                @lang('catalog.weight') : <b>{{$item->weight}}</b>
                                            </p>
                                            <p class="text-muted"><i
                                                        class="mdi mdi-checkbox-marked-circle-outline h6 text-primary mr-2"></i>
                                                @lang('catalog.created at') : <b>{{$item->created_at}}</b>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <p class="text-muted"><i
                                                        class="mdi mdi-checkbox-marked-circle-outline h6 text-primary mr-2"></i>
                                                @lang('catalog.pd') : <b>{{$item->pd}}</b>
                                            </p>
                                            <p class="text-muted"><i
                                                        class="mdi mdi-checkbox-marked-circle-outline h6 text-primary mr-2"></i>
                                                @lang('catalog.pt') : <b>{{$item->pt}}</b>
                                            </p>
                                            <p class="text-muted"><i
                                                        class="mdi mdi-checkbox-marked-circle-outline h6 text-primary mr-2"></i>
                                                @lang('catalog.rh') : <b>{{$item->rh}}</b>
                                            </p>
                                            <p class="text-muted"><i
                                                        class="mdi mdi-checkbox-marked-circle-outline h6 text-primary mr-2"></i>
                                                @lang('catalog.updated at') : <b>{{$item->updated_at}}</b>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/fancybox/fancybox.min.js')}}"></script>
@endsection
