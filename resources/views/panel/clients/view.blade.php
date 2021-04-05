@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/fancybox/fancybox.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="media">
                        @if(!empty($item->files))
                            <a href="/images/{{$item->files->file}}" data-fancybox
                               data-caption="{{$item->files->name}}">
                                <img class="d-flex mr-3 rounded-circle avatar-lg" src="/images/{{$item->files->file}}"
                                     alt="{{$item->files->name}}">
                            </a>
                        @endif
                        <div class="media-body">
                            <h4 class="mt-0 mb-1">{{$item->fullname()}}</h4>
                            <p class="text-muted"><i
                                        class="mdi mdi-office-building"></i> {{ ($item->clientIndustry) ? $item->clientIndustry->title : __('client.empty') }}
                            </p>

                            <a href="tel://{{$item->phone}}" class="btn- btn-xs btn-info">@lang('client.call')</a>
                            <a href="{{route('client.edit',$item->id)}}"
                               class="btn- btn-xs btn-secondary">@lang('client.edit_button')</a>
                            <a href="{{route('client.delete',$item->id)}}"
                               onclick="return confirm('{{__('index.confirmation')}}');"
                               class="btn- btn-xs btn-danger">@lang('client.delete')</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-box pt-1">
                    <h5 class="mb-3 text-uppercase bg-info p-2"><i class="mdi mdi-account-circle mr-1"></i>
                        @lang('client.commonInformation')</h5>
                    <div class="">
                        <h4 class="font-13 text-muted text-uppercase"> @lang('client.description') :</h4>
                        <p class="mb-3">
                            {{$item->description ?? __('client.empty')}}
                        </p>

                        <h4 class="font-13 text-muted text-uppercase"> @lang('client.phone') :</h4>
                        <p class="mb-3">
                            {{$item->phone ?? __('client.empty')}}
                        </p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.c_type')</h4>
                        <p class="mb-3"> {{ ($item->clientTypeRelation) ? $item->clientTypeRelation->title : __('client.empty')}}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.industry') :</h4>
                        <p class="mb-3">{{ ($item->clientIndustry) ? $item->clientIndustry->title : __('client.empty') }}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.group_id') :</h4>
                        <p class="mb-3">{{ ($item->clientGroupTypeRelation) ? $item->clientGroupTypeRelation->title : __('client.empty')}}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.assigned_user_id') :</h4>
                        <p class="mb-3">{{ ($item->assignedUser) ? $item->assignedUser->fullName() : __('client.empty')}}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.sic') :</h4>
                        <p class="mb-3">{{ $item->sic ?? __('client.empty')}}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.created_at') :</h4>
                        <p class="mb-3"> {{$item->created_at->format('Y-m-d H:i')}}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.updated_at') :</h4>
                        <p class="mb-0"> {{$item->updated_at->format('Y-m-d H:i')}}</p>

                    </div>

                </div> <!-- end card-box-->
            </div>

            <div class="col-lg-4">
                <div class="card-box pt-1">
                    <h5 class="mb-3 text-uppercase bg-info p-2"><i class="mdi mdi-account-circle mr-1"></i>
                        @lang('client.billingInfo')</h5>
                    <div class="">
                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.billing_address_country')</h4>
                        <p class="mb-3"> {{ ($item->countriesBillingRelation) ? $item->countriesBillingRelation->title : __('client.empty')}}</p>


                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.billing_address_state')</h4>
                        <p class="mb-3"> {{ $item->billing_address_state ?? __('client.empty')}}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.billing_address_city')</h4>
                        <p class="mb-3"> {{ ($item->citiesBilling) ? $item->citiesBilling->title : __('client.empty')}} </p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.billing_address_street')</h4>
                        <p class="mb-3"> {{ $item->billing_address_street ?? __('client.empty')}}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.billing_address_postal_code')</h4>
                        <p class="mb-3"> {{ $item->billing_address_postal_code ?? __('client.empty')}}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.billing_name_bank')</h4>
                        <p class="mb-3"> {{ $item->billing_name_bank ?? __('client.empty')}}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.billing_bank_account')</h4>
                        <p class="mb-3"> {{ $item->billing_bank_account ?? __('client.empty')}}</p>

                    </div>

                </div> <!-- end card-box-->
            </div>

            <div class="col-lg-4">
                <div class="card-box pt-1">
                    <h5 class="mb-3 text-uppercase bg-info p-2"><i class="mdi mdi-account-circle mr-1"></i>
                        @lang('client.shippingInfo')</h5>
                    <div class="">
                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.shipping_address_country')</h4>
                        <p class="mb-3"> {{ ($item->countriesShippingRelation) ? $item->countriesShippingRelation->title : __('client.empty')}}</p>


                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.shipping_address_state')</h4>
                        <p class="mb-3"> {{ $item->shipping_address_state ?? __('client.empty')}}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.shipping_address_city')</h4>
                        <p class="mb-3"> {{ ($item->citiesShipping) ? $item->citiesShipping->title : __('client.empty')}} </p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.shipping_address_street')</h4>
                        <p class="mb-3"> {{ $item->shipping_address_street ?? __('client.empty')}}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.shipping_address_postal_code')</h4>
                        <p class="mb-3"> {{ $item->shipping_address_postal_code ?? __('client.empty')}}</p>

                    </div>

                </div> <!-- end card-box-->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/fancybox/fancybox.min.js')}}"></script>
@endsection
