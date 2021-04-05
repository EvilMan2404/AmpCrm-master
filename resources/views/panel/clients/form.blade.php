@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"
          xmlns="http://www.w3.org/1999/html"/>

    <style>
        .invalid-feedback {
            display: block !important;
        }
    </style>

    <!-- App css -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="clientForm" method="post" enctype="multipart/form-data"
                              action="{{route('client.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                            @csrf
                            <div class="row">
                                <div class="col-xl-4">

                                    <div class="form-group">
                                        <label for="companyName">@lang('client.name')</label>
                                        <input type="text" id="companyName" name="name"
                                               class="form-control @error('name') is-invalid @enderror" required
                                               data-parsley-required-message="@lang('client.errors.name')"
                                               placeholder="@lang('client.name')"
                                               value="{{  old('name',$item->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="third_name">@lang('client.third_name')</label>
                                        <input name="third_name"
                                               class="form-control @error('third_name') is-invalid @enderror"
                                               data-parsley-required-message="@lang('client.errors.third_name')"

                                               placeholder="@lang('client.third_name')"
                                               value="{{old('third_name',$item->third_name)}}">
                                        @error('third_name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="second_name">@lang('client.second_name')</label>
                                        <div>
                                            <input id="second_name" name="second_name" type="text"
                                                   class="form-control @error('second_name') is-invalid @enderror"
                                                   placeholder="@lang('client.second_name')"
                                                   data-parsley-required-message="@lang('client.errors.second_name')"

                                                   value="{{  old('second_name',$item->second_name) }}">
                                        </div>
                                        @error('second_name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">@lang('client.phone')</label>
                                        <div>
                                            <input id="phone" name="phone" type="tel"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   data-parsley-required-message="@lang('client.errors.phone')"
                                                   required placeholder="@lang('client.phone')"
                                                   value="{{ old('phone',$item->phone) }}"/>
                                        </div>
                                        @error('phone')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label
                                                for="c_type">@lang('client.c_type')</label>
                                        <div id="c_type_container">
                                            <select id="c_type" name="client_type"
                                                    class="form-control  @error('client_type') is-invalid @enderror"
                                                    data-parsley-required-message="@lang('client.errors.c_type')"
                                                    data-parsley-errors-container="#c_type_container"
                                                    required
                                                    data-toggle="select2">
                                                @foreach($client_types as $value)
                                                    <option @if(old('client_type',$item->client_type) === $value->id) selected
                                                            @endif value="{{$value->id}}">{{$value->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('client_type')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label
                                                for="industry">@lang('client.industry')</label>
                                        <div id="industry_id_container">
                                            <select id="industry" name="industry_id"
                                                    class="form-control  @error('industry_id') is-invalid @enderror"
                                                    data-parsley-required-message="@lang('client.errors.industry_id')"
                                                    data-parsley-errors-container="#industry_id_container"
                                                    data-toggle="select2">
                                                @foreach($industries as $value)
                                                    <option @if(old('industry_id',$item->industry_id) === $value->id) selected
                                                            @endif value="{{$value->id}}">{{$value->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('industry_id')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label
                                                for="description">@lang('client.description')</label>
                                        <div>
                                            <textarea id="description" name="description"
                                                      class="form-control @error('description') is-invalid @enderror"
                                                      data-parsley-required-message="@lang('client.errors.description')"

                                                      placeholder="@lang('client.description')">{{  old('description',$item->description) }}</textarea>
                                        </div>
                                        @error('description')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label
                                                for="assigned_user_id">@lang('client.assigned_user_id')</label>
                                        <div id="assigned_user_container">
                                            <select id="assigned_user_id" name="assigned_user_id"
                                                    class="form-control  @error('assigned_user_id') is-invalid @enderror"

                                                    data-info="{{route('request.getUsers')}}"
                                                    data-searching="@lang('client.search.searching')"
                                                    data-no-results="@lang('client.search.noResults')"
                                                    data-start="@lang('client.search.start')"
                                                    data-placeholder="@lang('client.search.startSearching')"
                                                    data-url="{{route('request.getUsers')}}"

                                                    data-parsley-errors-container="#assigned_user_container"
                                                    data-toggle="select2">
                                                @if(!empty($assignedUserInfo->id))
                                                    <option selected="selected"
                                                            value="{{$assignedUserInfo->id}}">{{$assignedUserInfo->fullname()}}</option>
                                                @endif
                                            </select>
                                        </div>
                                        @error('assigned_user_id')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- end col-->
                                <div class="col-xl-4">


                                    <div class="col-xl-6 m-auto mb-3">
                                        <div class="attach-logo">
                                            <div class="form-group">
                                                <label class="label">
                                                    @if(!empty($item->id) && $item->files)
                                                        <img class="img-fluid" src="/images/{{$item->files->file}}"
                                                             alt="{{$item->files->name}}"/>
                                                    @else
                                                        <i class="material-icons">attach_file</i>
                                                        <span class="title d-block m-auto">Загрузить логотип</span>
                                                    @endif
                                                    <input type="file" name="photo" id="gallery-photo-add"
                                                           value="{{  old('photo') }}"
                                                           data-parsley-required-message="@lang('client.errors.photo')"
                                                    >
                                                </label>
                                            </div>
                                        </div>
                                        @error('photo')
                                        <div class="invalid-feedback" style="display:block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                        @if (session('photo'))
                                            <div class="invalid-feedback" style="display:block;">
                                                <strong>{{ session('photo')}}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    <div id="billing_address_country" class="form-group">
                                        <label for="country">@lang('client.billing_address_country')</label>
                                        <select id="country" name="billing_address_country"
                                                data-searching="@lang('client.search.searching')"
                                                data-no-results="@lang('client.search.noResults')"
                                                data-start="@lang('client.search.start')"
                                                data-placeholder="@lang('client.form.choose_country')"
                                                class="form-control  @error('billing_address_country') is-invalid @enderror"
                                                data-parsley-errors-container="#billing_address_country"
                                                data-parsley-required-message="@lang('client.errors.billing_address_country')"

                                                data-toggle="select2">
                                            @if(!old('billing_address_country',$item->billing_address_country))
                                                <option disabled selected>@lang('client.form.choose_country')</option>
                                            @endif
                                            @foreach($country as $value)
                                                <option
                                                        @if((int)old('billing_address_country',$item->billing_address_country) === $value->id) selected="selected"
                                                        @endif value="{{$value->id}}">{{$value->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('billing_address_country')
                                        <div class="invalid-feedback" style="display:block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label
                                                for="billing_address_state">@lang('client.billing_address_state')</label>
                                        <div>
                                            <input id="billing_address_state" name="billing_address_state" type="text"
                                                   class="@error('billing_address_state') is-invalid @enderror form-control"
                                                   placeholder="@lang('client.billing_address_state')"
                                                   data-parsley-required-message="@lang('client.errors.billing_address_state')"
                                                   value="{{old('billing_address_state',$item->billing_address_state)}}"
                                            >
                                        </div>
                                        @error('billing_address_state')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="billing_address_city">@lang('client.billing_address_city')</label>
                                        <div id="billing_address_city-block">
                                            <select id="billing_address_city" name="billing_address_city"
                                                    class="@error('billing_address_city') is-invalid @enderror form-control"

                                                    data-searching="@lang('client.search.searching')"
                                                    data-no-results="@lang('client.search.noResults')"
                                                    data-start="@lang('client.search.start')"
                                                    data-placeholder="@lang('client.form.choose_country_first')"
                                                    data-url="{{route('request.getCities')}}"
                                                    data-parsley-errors-container="#billing_address_city-block"
                                                    data-parsley-required-message="@lang('client.errors.billing_address_city')"

                                                    data-toggle="select2">

                                                @if(!empty($billingCityInfo->id))
                                                    <option selected="selected"
                                                            value="{{$billingCityInfo->id}}">{{$billingCityInfo->title}}</option>
                                                @endif
                                            </select>
                                        </div>
                                        @error('billing_address_city')
                                        <div class="invalid-feedback" style="display:block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label
                                                for="billing_address_street">@lang('client.billing_address_street')</label>
                                        <div>
                                            <input id="billing_address_street" name="billing_address_street" type="text"
                                                   class="form-control @error('billing_address_street') is-invalid @enderror"
                                                   placeholder="@lang('client.billing_address_street')"
                                                   data-parsley-required-message="@lang('client.errors.billing_address_street')"
                                                   value="{{old('billing_address_street',$item->billing_address_street)}}"/>
                                        </div>
                                        @error('billing_address_street')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label
                                                for="billing_address_postal_code">@lang('client.billing_address_postal_code')</label>
                                        <div>
                                            <input id="billing_address_postal_code" name="billing_address_postal_code"
                                                   type="text"
                                                   class="form-control  @error('billing_address_postal_code') is-invalid @enderror"
                                                   placeholder="@lang('client.billing_address_postal_code')"
                                                   data-parsley-required-message="@lang('client.errors.billing_address_postal_code')"
                                                   value="{{old('billing_address_postal_code',$item->billing_address_postal_code)}}"/>
                                        </div>
                                        @error('billing_address_postal_code')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label
                                                for="billing_name_bank">@lang('client.billing_name_bank')</label>
                                        <div>
                                            <input id="billing_name_bank" name="billing_name_bank" type="text"
                                                   class="form-control @error('billing_name_bank') is-invalid @enderror"
                                                   placeholder="@lang('client.billing_name_bank')"
                                                   data-parsley-required-message="@lang('client.errors.billing_name_bank')"
                                                   value="{{old('billing_name_bank',$item->billing_name_bank)}}"/>
                                        </div>
                                        @error('billing_name_bank')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label
                                                for="billing_bank_account">@lang('client.billing_bank_account')</label>
                                        <div>
                                            <input id="billing_bank_account" name="billing_bank_account" type="text"
                                                   class="form-control @error('billing_bank_account') is-invalid @enderror"
                                                   placeholder="@lang('client.billing_bank_account')"
                                                   data-parsley-required-message="@lang('client.errors.billing_bank_account')"
                                                   value="{{old('billing_bank_account',$item->billing_bank_account)}}"/>
                                        </div>
                                        @error('billing_bank_account')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- end col-->
                                <div class="col-xl-4">
                                    <div id="shipping_address_country" class="form-group">
                                        <label for="country-shipping">@lang('client.shipping_address_country')</label>
                                        <select id="country-shipping" name="shipping_address_country"
                                                class="form-control  @error('shipping_address_country') is-invalid @enderror"
                                                data-parsley-errors-container="#shipping_address_country"
                                                data-parsley-required-message="@lang('client.errors.shipping_address_country')"

                                                data-toggle="select2">
                                            @if(!old('shipping_address_country',$item->shipping_address_country))
                                                <option disabled
                                                        selected>@lang('client.form.shipping_address_country')</option>
                                            @endif
                                            @foreach($country as $value)
                                                <option
                                                        @if((int)old('shipping_address_country',$item->shipping_address_country) === $value->id) selected="selected"
                                                        @endif value="{{$value->id}}">{{$value->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('shipping_address_country')
                                        <div class="invalid-feedback" style="display:block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label
                                                for="shipping_address_state">@lang('client.shipping_address_state')</label>
                                        <div>
                                            <input id="shipping_address_state" name="shipping_address_state" type="text"
                                                   class="@error('shipping_address_state') is-invalid @enderror form-control"
                                                   placeholder="@lang('client.shipping_address_state')"
                                                   data-parsley-required-message="@lang('client.errors.shipping_address_state')"
                                                   value="{{old('shipping_address_state',$item->shipping_address_state)}}"
                                            >
                                        </div>
                                        @error('shipping_address_state')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="shipping_address_city">@lang('client.shipping_address_city')</label>
                                        <div id="shipping_address_city-container">
                                            <select id="shipping_address_city" name="shipping_address_city"
                                                    class="@error('shipping_address_city') is-invalid @enderror form-control"

                                                    data-searching="@lang('client.search.searching')"
                                                    data-no-results="@lang('client.search.noResults')"
                                                    data-start="@lang('client.search.start')"
                                                    data-placeholder="@lang('client.form.choose_country_first')"
                                                    data-url="{{route('request.getCities')}}"

                                                    data-parsley-errors-container="#shipping_address_city-container"
                                                    data-parsley-required-message="@lang('client.errors.shipping_address_city')"

                                                    data-toggle="select2">
                                                @if(!empty($shippingCityInfo->id))
                                                    <option selected="selected"
                                                            value="{{$shippingCityInfo->id}}">{{$shippingCityInfo->title}}</option>
                                                @endif
                                            </select>
                                        </div>
                                        @error('shipping_address_city')
                                        <div class="invalid-feedback" style="display:block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label
                                                for="shipping_address_street">@lang('client.shipping_address_street')</label>
                                        <div>
                                            <input id="shipping_address_street" name="shipping_address_street"
                                                   type="text"
                                                   class="form-control @error('shipping_address_street') is-invalid @enderror"
                                                   placeholder="@lang('client.shipping_address_street')"
                                                   data-parsley-required-message="@lang('client.errors.shipping_address_street')"
                                                   value="{{old('shipping_address_street',$item->shipping_address_street)}}"/>
                                        </div>
                                        @error('shipping_address_street')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label
                                                for="shipping_address_postal_code">@lang('client.shipping_address_postal_code')</label>
                                        <div>
                                            <input id="shipping_address_postal_code" name="shipping_address_postal_code"
                                                   type="text"
                                                   class="form-control  @error('shipping_address_postal_code') is-invalid @enderror"
                                                   placeholder="@lang('client.shipping_address_postal_code')"
                                                   data-parsley-required-message="@lang('client.errors.shipping_address_postal_code')"
                                                   value="{{old('shipping_address_postal_code',$item->shipping_address_postal_code)}}"/>
                                        </div>
                                        @error('shipping_address_postal_code')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label
                                                for="group_id">@lang('client.group_id')</label>
                                        <div id="group_id-container">
                                            <select id="group_id" name="group_id"
                                                    class="@error('group_id') is-invalid @enderror form-control"
                                                    data-parsley-errors-container="#group_id-container"
                                                    data-parsley-required-message="@lang('client.errors.group_id')"

                                                    data-toggle="select2">
                                                @foreach($client_group_types as $value)
                                                    <option @if(old('group_id',$item->group_id) === $value->id) selected
                                                            @endif value="{{$value->id}}">{{$value->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('group_id')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label
                                                for="sic">@lang('client.sic')</label>
                                        <div>
                                            <input id="sic" name="sic" type="text"
                                                   class="form-control @error('sic') is-invalid @enderror"
                                                   placeholder="@lang('client.sic')"
                                                   data-parsley-required-message="@lang('client.errors.sic')"
                                                   value="{{old('sic',$item->sic)}}"/>
                                        </div>
                                        @error('sic')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>


                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    @if(!empty($item->id))
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                    class="fe-check-circle mr-1"></i> @lang('client.edit')
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                    class="fe-check-circle mr-1"></i> @lang('client.create')
                                        </button>
                                    @endif
                                    <button type="button" onclick="location='{{route('client.index')}}'"
                                            class="btn btn-light waves-effect waves-light m-1"><i
                                                class="fe-x mr-1"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </form> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>
            <!-- end row-->

        </div> <!-- container -->


        @endsection

        @section('script')
            <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
            <!-- Plugin js-->
            <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
            <script src="{{ URL::asset('assets/js/pages/clients.init.js')}}"></script>
@endsection
