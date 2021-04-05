@extends('layouts.master')
@section('css')
    <!-- Plugins css -->
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)


        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" id="form"
                              action="{{route('purchase.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                            @csrf
                            @if(!empty($success))
                                <div class="alert alert-success">{{$success}}</div>
                            @endif
                            @if(!empty($isDoneStatus))
                                <div class="alert alert-danger">@lang('purchase.errors.alreadyDonePurchase')</div>
                            @endif
                            @error('files')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <div class="col-xl-12 mb-2">
                                            <label for="catalogName">@lang('purchase.name')</label>
                                            <input data-parsley-required
                                                   data-parsley-required-message="@lang('purchase.errors.name')"
                                                   type="text"
                                                   id="catalogName" name="name" value="{{old('name',$item->name)}}"
                                                   class="@error('name') is-invalid @enderror form-control"
                                                   placeholder="@lang('purchase.name')">
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <!-- Date View -->

                                            <div class="form-group">
                                                <label for="categories">@lang('purchase.categories')</label>
                                                <div>
                                                    <select
                                                            data-info="{{route('request.getCatalog')}}"
                                                            data-searching="@lang('purchase.search.searching')"
                                                            data-no-results="@lang('purchase.search.noResults')"
                                                            data-start="@lang('purchase.search.start')"
                                                            data-placeholder="@lang('purchase.search.categories')"
                                                            data-url="{{route('request.getCategories')}}"
                                                            multiple="multiple" id="categories" name="categories[]"
                                                            class="@error('categories') is-invalid @enderror form-control"
                                                            data-toggle="select2">

                                                        @foreach($catalogInfo as $value)
                                                            <option selected="selected"
                                                                    value="{{$value->id}}">{{$value->name}}
                                                                | {{$value->carIdRelation->name}}
                                                                | {{$value->serial_number}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                @error('categories')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror

                                            </div>

                                        </div>

                                        <div class="col-lg-6">
                                            <!-- Date View -->
                                            <div class="form-group">
                                                <label for="lots">@lang('purchase.lots')</label>
                                                <div>
                                                    <select
                                                            data-info="{{route('request.getLot')}}"
                                                            data-searching="@lang('purchase.search.searching')"
                                                            data-no-results="@lang('purchase.search.noResults')"
                                                            data-start="@lang('purchase.search.start')"
                                                            data-placeholder="@lang('purchase.search.lots')"
                                                            data-url="{{route('request.getLots')}}"
                                                            id="lots" name="lot"
                                                            class="@error('lot') is-invalid @enderror form-control"
                                                            data-toggle="select2">
                                                        @if(!empty($lotInfo->id))
                                                            <option selected="selected"
                                                                    value="{{$lotInfo->id}}">{{$lotInfo->name}} {{($lotInfo->company) ? $lotInfo->company->name : ''}}</option>
                                                        @endif
                                                    </select>
                                                    @error('lot')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>

                                            </div>

                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label for="status">@lang('purchase.status')</label>
                                                <div>
                                                    <select
                                                            data-searching="@lang('purchase.search.searching')"
                                                            data-no-results="@lang('purchase.search.noResults')"
                                                            data-start="@lang('purchase.search.start')"
                                                            data-placeholder="@lang('purchase.search.status')"
                                                            id="status" name="status_id"
                                                            class="@error('status_id') is-invalid @enderror form-control"
                                                            data-toggle="select2">
                                                        @foreach($statuses as $status)
                                                            <option @if($status->id === $item->status_id) selected="selected"
                                                                    @endif value="{{$status->id}}">{{$status->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('status_id')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>


                                            </div>

                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label for="type_payment">@lang('purchase.type_payment')</label>
                                                <div>
                                                    <select
                                                            data-searching="@lang('purchase.search.searching')"
                                                            data-no-results="@lang('purchase.search.noResults')"
                                                            data-start="@lang('purchase.search.start')"
                                                            data-placeholder="@lang('purchase.search.status')"
                                                            id="type_payment" name="type_payment"
                                                            class="@error('type_payment') is-invalid @enderror form-control"
                                                            data-toggle="select2">
                                                        @foreach($paymentTypes as $type)
                                                            <option @if($type->id === $item->type_payment) selected="selected"
                                                                    @endif value="{{$type->id}}">{{$type->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('type_payment')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>


                                            </div>

                                        </div>
                                        <div class="col-xl-6">
                                            <!-- Date View -->
                                            <div class="form-group">
                                                <label for="client_id">@lang('purchase.client')</label>
                                                <div id="client_id_container">
                                                    <select
                                                            data-searching="@lang('purchase.search.searching')"
                                                            data-no-results="@lang('purchase.search.noResults')"
                                                            data-start="@lang('purchase.search.start')"
                                                            data-placeholder="@lang('purchase.search.client')"
                                                            data-url="{{route('request.getClients')}}"
                                                            id="client_id" name="client_id"
                                                            class="@error('client_id') is-invalid @enderror form-control"

                                                            data-parsley-errors-container="#client_id_container"
                                                            data-toggle="select2">
                                                        @if(!empty($clientInfo->id))
                                                            <option selected="selected"
                                                                    value="{{$clientInfo->id}}">{{$clientInfo->fullname()}}
                                                                | {{$clientInfo->phone}}</option>
                                                        @endif
                                                    </select>
                                                    @error('client_id')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>

                                            </div>

                                        </div>
                                        <div class="col-xl-3">
                                            <label for="catalogPaid">@lang('purchase.paid')</label>
                                            <input
                                                    type="text"
                                                    data-parsley-type="number"
                                                    id="catalogPaid" name="paid" value="{{old('paid',$item->paid)}}"
                                                    class="@error('paid') is-invalid @enderror form-control"
                                                    placeholder="@lang('purchase.paid')">
                                            @error('paid')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-xl-3">
                                            <label for="catalogPaid">@lang('purchase.paid_card')</label>
                                            <input
                                                    type="text"
                                                    data-parsley-type="number"
                                                    id="catalogPaid" name="paid_card"
                                                    value="{{old('paid_card',$item->paid_card)}}"
                                                    class="@error('paid_card') is-invalid @enderror form-control"
                                                    placeholder="@lang('purchase.paid_card')">
                                            @error('paid_card')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-lg-6">
                                            <!-- Date View -->
                                            <div class="form-group">
                                                <label for="user_paid">@lang('purchase.user_paid')</label>
                                                <div id="user_paid_container">
                                                    <select
                                                            data-searching="@lang('purchase.search.searching')"
                                                            data-no-results="@lang('purchase.search.noResults')"
                                                            data-start="@lang('purchase.search.start')"
                                                            data-placeholder="@lang('purchase.search.user_paid')"
                                                            data-url="{{route('request.getUsers')}}"
                                                            id="user_paid" name="user_paid"
                                                            class="@error('user_paid') is-invalid @enderror form-control"
                                                            data-parsley-errors-container="#user_paid_container"
                                                            data-parsley-required-message="@lang('purchase.errors.user_paid')"
                                                            required
                                                            data-toggle="select2">
                                                        @if(!empty($userPaid->id))
                                                            <option selected="selected"
                                                                    value="{{$userPaid->id}}">{{$userPaid->fullname()}}</option>
                                                        @endif
                                                    </select>
                                                    @error('user_paid')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="project-overview">@lang('purchase.description')</label>
                                        <textarea class="form-control" id="project-overview" name="description" rows="5"
                                                  placeholder="@lang('purchase.description')">{{old('description',$item->description)}}</textarea>
                                    </div>


                                </div> <!-- end col-->

                                <div class="col-xl-6">
                                    {{--                                    catalog list --}}
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h3>@lang('purchase.listOfCatalogs')</h3>
                                            <div class="table-responsive">
                                                <table id="table_catalog"
                                                       class="table table-borderless mb-0">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>@lang('purchase.catalog')</th>
                                                        <th>@lang('purchase.price')</th>
                                                        <th>@lang('purchase.amount')</th>
                                                        <th>@lang('purchase.sale/price')</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($item->catalogs as $value)
                                                        <tr data-id="{{$value->id}}">
                                                            <td data-tag="name"></td>
                                                            <td data-tag="price"></td>
                                                            <td data-tag="count">
                                                                <input class="form-control catalog_count" type="number"
                                                                       value="{{$value->pivot->count}}"
                                                                       name="cat[{{$value->id}}][count]">
                                                            </td>
                                                            <td data-tag="form">
                                                                <div><input class="form-control discount_value"
                                                                            type="text"
                                                                            value="{{$value->pivot->discount}}"
                                                                            name="cat[{{$value->id}}][discount]"></div>
                                                                <div class="mt-1 ml-1">
                                                                    <div class="radio radio-info form-check-inline">
                                                                        <input class="discount_type" type="radio"
                                                                               id="cat[{{$value->id}}][discount_type_percent]"
                                                                               value="percent"
                                                                               name="cat[{{$value->id}}][discount_type]"
                                                                               @if($value->pivot->discount_type === \App\Models\Purchase::DISCOUNT_TYPE_PERCENT) checked="checked" @endif>
                                                                        <label for="cat[{{$value->id}}][discount_type_percent]">
                                                                            Процент </label>
                                                                    </div>
                                                                    <div class="radio radio-info form-check-inline">
                                                                        <input class="discount_type" type="radio"
                                                                               id="cat[{{$value->id}}][discount_type_money]"
                                                                               value="money"
                                                                               name="cat[{{$value->id}}][discount_type]"
                                                                               @if($value->pivot->discount_type === \App\Models\Purchase::DISCOUNT_TYPE_MONEY) checked="checked" @endif>
                                                                        <label for="cat[{{$value->id}}][discount_type_money]">
                                                                            Стоимость </label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                    </div>

                                    {{--                                    total--}}
                                    <div class="row mt-3">
                                        <div class="col-lg-12">
                                            <h3>@lang('purchase.summary')</h3>

                                            <!-- Date View -->

                                            <div class="table-responsive">
                                                <table id="table"
                                                       data-discount-pt="{{$discount->pt_discount}}"
                                                       data-discount-pd="{{$discount->pd_discount}}"
                                                       data-discount-rh="{{$discount->rh_discount}}"

                                                       data-discount-purchase="{{$discount->purchase_discount}}"
                                                       class="table table-borderless mb-0">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>PT @lang('purchase.gram')</th>
                                                        <th>PD @lang('purchase.gram')</th>
                                                        <th>RH @lang('purchase.gram')</th>
                                                        <th>@lang('purchase.table.total_weight')</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>

                                                        <td class="pt_calc">0</td>
                                                        <td class="pd_calc">0</td>
                                                        <td class="rh_calc">0</td>
                                                        <td class="wgkg_calc">0</td>
                                                    </tr>
                                                    <tr class="table-info">

                                                        <td class="font-weight-bold">@lang('purchase.table.total_price')</td>
                                                        <td colspan="3" class="total_calc font-weight-bold">0</td>

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
                                </div> <!-- end col-->
                            </div>
                            <!-- end row -->


                        </form>


                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                @if(!empty($item->id))
                                    <button id="buttonSubmit" type="button"
                                            class="btn btn-success waves-effect waves-light m-1"><i
                                                class="fe-check-circle mr-1"></i> @lang('purchase.edit')
                                    </button>
                                @else
                                    <button id="buttonSubmit" type="button"
                                            class="btn btn-success waves-effect waves-light m-1"><i
                                                class="fe-check-circle mr-1"></i> @lang('purchase.create')
                                    </button>
                                @endif

                                <a href="{{route('purchase.index')}}">
                                    <button type="button" class="btn btn-light waves-effect waves-light m-1"><i
                                                class="fe-x mr-1"></i> @lang('purchase.cancel')
                                    </button>
                                </a>
                            </div>
                        </div>

                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->

    </div> <!-- container -->

    <div class="translation d-none" data-percent='@lang('purchase.percent')' data-price='@lang('purchase.price')'></div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/purchase.init.js')}}"></script>
    <script>
    </script>
@endsection
