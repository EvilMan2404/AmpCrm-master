@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/fancybox/fancybox.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)
        <div class="row">
            <div class="col-lg-12 m-auto">
                <div class="card-box bg-pattern">
                    <div class="text-center">
                        @if(!empty($item->files))
                            <a href="/images/{{$item->files->file}}" data-fancybox
                               data-caption="{{$item->files->name}}">
                                <img src="/images/{{$item->files->file}}" class="rounded-circle" alt="{{$item->files->name}}"/>
                            </a>
                        @endif
                        <h4 class="mb-1 font-20">{{$item->name}}</h4>
                        <p class="text-muted  font-14">{{ ($item->countriesRelation) ? $item->countriesRelation->title : 'Unknown'}}
                            ,
                            {{ $item->billing_address_state ?? 'Unknown'}}
                            , {{ ($item->citiesRelation) ? $item->citiesRelation->title : 'Unknown'}} ,
                            {{ $item->billing_address_street ?? 'Unknown'}}</p>
                    </div>

                    <p class="font-14 text-center text-muted">
                        {{$item->description}}
                    </p>

                    <div class="row mt-4 text-center">
                        <div class="col-md-4">

                            <h5 class="font-weight-normal text-muted">@lang('company.email')</h5>
                            <h4>{{$item->email}}</h4>

                        </div>
                        <div class="col-md-4">
                            <h5 class="font-weight-normal text-muted">@lang('company.phone')</h5>
                            <h4>{{$item->phone}}</h4>
                        </div>
                        <div class="col-md-4">
                            <h5 class="font-weight-normal text-muted">@lang('company.website')</h5>
                            <h4><a href="https://{{$item->website}}" title="{{$item->website}}">Перейти на сайт
                                    компании</a></h4>
                        </div>
                        <div class="col-md-4">
                            <h5 class="font-weight-normal text-muted">@lang('company.billing_address')</h5>
                            <h4>{{$item->billing_address}}</h4>
                        </div>
                        <div class="col-md-4">
                            <h5 class="font-weight-normal text-muted">@lang('company.shipping_address')</h5>
                            <h4>{{$item->shipping_address}}</h4>
                        </div>
                        <div class="col-md-4">
                            <h5 class="font-weight-normal text-muted">@lang('company.payment_info')</h5>
                            <h4>{{$item->payment_info}}</h4>
                        </div>
                        <div class="col-md-4 m-auto">
                            <h5 class="font-weight-normal text-muted">@lang('company.last_user_id')</h5>
                            <h4>{{ ($item->userEdited) ? $item->userEdited->fullName() : 'unknown'}}</h4>
                        </div>
                    </div>
                </div> <!-- end card-box -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/fancybox/fancybox.min.js')}}"></script>
@endsection
