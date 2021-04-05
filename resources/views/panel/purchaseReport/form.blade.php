@extends('layouts.master')
@section('css')
    <!-- Plugins css -->
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .invalid-feedback {
            display: block !important;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)


        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" id="form"
                              action="{{route('purchaseReports.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                            @csrf
                            <input type="hidden" id="id_page" value="{{$item->id??0}}">
                            <input type="hidden" id="previous_info" value="{{$item->history??'{}'}}">
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
                                <div class="col-xl-4">
                                    <div class="form-group row">
                                        <div class="col-xl-12 mb-2">
                                            <label for="catalogName">@lang('purchaseReports.name')</label>
                                            <input data-parsley-required
                                                   data-parsley-required-message="@lang('purchaseReports.errors.name')"
                                                   type="text"
                                                   id="catalogName" name="name" value="{{old('name',$item->name)}}"
                                                   class="@error('name') is-invalid @enderror form-control"
                                                   placeholder="@lang('purchaseReports.name')">
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                </div> <!-- end col-->
                                <div class="col-xl-4">
                                    <div class="form-group row">
                                        <div class="col-xl-12 mb-2">
                                            <label for="date_start">@lang('purchaseReports.date_start')</label>
                                            <input
                                                    type="date"
                                                    style="cursor: not-allowed" disabled
                                                    value="{{$lastweek['start']}}"
                                                    class="form-control"
                                                    placeholder="@lang('purchaseReports.date_start')">
                                        </div>
                                    </div>

                                </div> <!-- end col-->
                                <div class="col-xl-4">
                                    <div class="form-group row">
                                        <div class="col-xl-12 mb-2">
                                            <label for="date_finish">@lang('purchaseReports.date_finish')</label>
                                            <input
                                                    type="date"
                                                    style="cursor: not-allowed" disabled
                                                    value="{{$lastweek['end']}}"
                                                    class="form-control"
                                                    placeholder="@lang('purchaseReports.date_finish')">
                                        </div>
                                    </div>

                                </div> <!-- end col-->

                                <div class="col-lg-4">
                                    <!-- Date View -->

                                    <div id="user-errors" class="form-group">
                                        <label for="user_id">@lang('purchaseReports.user_id')</label>
                                        <div>
                                            <select
                                                    data-parsley-required
                                                    data-parsley-errors-container="#user-errors"
                                                    data-parsley-required-message="@lang('purchaseReports.errors.required')"
                                                    data-searching="@lang('purchaseReports.search.searching')"
                                                    data-no-results="@lang('purchaseReports.search.noResults')"
                                                    data-start="@lang('purchaseReports.search.start')"
                                                    data-placeholder="@lang('purchaseReports.user_id')"
                                                    data-url="{{route('request.getUsers')}}"
                                                    id="user_id" name="user_id"
                                                    class="@error('user_id') is-invalid @enderror form-control"
                                                    data-toggle="select2">
                                                @if(!empty($userInfo->id))
                                                    <option selected="selected"
                                                            value="{{$userInfo->id}}">{{$userInfo->fullname()}}</option>
                                                @endif

                                            </select>
                                        </div>
                                        @error('user_id')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror

                                    </div>

                                </div>

                                <div class="col-lg-4">
                                    <!-- Date View -->

                                    <div id="stock-errors" class="form-group">
                                        <label for="stock">@lang('purchaseReports.stocks')</label>
                                        <div>
                                            <select
                                                    data-parsley-required
                                                    data-parsley-errors-container="#stock-errors"
                                                    data-parsley-required-message="@lang('purchaseReports.errors.stocks')"
                                                    data-info="{{route('request.getStockTotal')}}"
                                                    data-searching="@lang('purchaseReports.search.searching')"
                                                    data-no-results="@lang('purchaseReports.search.noResults')"
                                                    data-start="@lang('purchaseReports.search.start')"
                                                    data-placeholder="@lang('purchaseReports.stocks')"
                                                    data-url="{{route('request.getStocks')}}"
                                                    multiple="multiple" id="stocks" name="stocks[]"
                                                    class="@error('stocks') is-invalid @enderror form-control"
                                                    data-toggle="select2">

                                                @foreach($stockInfo as $value)
                                                    <option selected="selected"
                                                            value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        @error('stocks')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                        @error('stocks.*')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror

                                    </div>

                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label for="waste_types">@lang('purchaseReports.wastes')</label>
                                        <div>
                                            <select
                                                    data-info="{{route('request.getWasteInfo')}}"
                                                    data-searching="@lang('purchaseReports.search.searching')"
                                                    data-no-results="@lang('purchaseReports.search.noResults')"
                                                    data-start="@lang('purchaseReports.search.start')"
                                                    data-placeholder="@lang('purchaseReports.search.waste')"
                                                    id="waste_types" name="waste_types[]"
                                                    multiple="multiple"
                                                    class="@error('waste_types') is-invalid @enderror form-control"
                                                    data-toggle="select2">
                                                @foreach($wasteTypes as $type)
                                                    <option @if(in_array($type->id,old('waste_types.*',$wastesUsedArray),true)) selected
                                                            @endif value="{{$type->id}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('wastes_sum.*')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>


                                    </div>

                                </div>
                                <div class="col-xl-6 mt-4">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>@lang('purchaseReports.table.nameStock')</th>
                                                <th>@lang('purchaseReports.table.totalStock')</th>
                                            </tr>
                                            </thead>
                                            <tbody id="stock-body">
                                            <tr class="table-info">
                                                <td class="font-weight-bold">@lang('purchaseReports.table.summary')</td>
                                                <td colspan="2" class="total_calc font-weight-bold text-center"
                                                    id="summaryStock">0 €
                                                </td>
                                            </tr>

                                            </tbody>

                                        </table>
                                    </div>
                                </div> <!-- end col-->

                                <div class="col-xl-6 mt-4">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                            <tr>
                                                <th>@lang('purchaseReports.table.nameWaste')</th>
                                                <th>@lang('purchaseReports.table.wasteSum')</th>
                                            </tr>
                                            </thead>
                                            <tbody id="wastes-body">
                                            <tr class="table-info">
                                                <td class="font-weight-bold">@lang('purchaseReports.table.summary')</td>
                                                <td colspan="1" class="total_calc font-weight-bold text-center"
                                                    id="summaryWastes">0 €
                                                </td>
                                            </tr>

                                            </tbody>

                                        </table>
                                    </div>
                                </div> <!-- end col-->


                                <div class="col-xl-12 mt-2">
                                    <div class="form-group row">
                                        <div class="col-xl-12 mb-2">
                                            <label for="summaryTotal">@lang('purchaseReports.table.summary')</label>
                                            <input id="summaryTotal" value="0"
                                                   class="form-control"
                                                   disabled
                                                   style="cursor: not-allowed"
                                                   placeholder="@lang('purchaseReports.table.summary')">
                                        </div>
                                    </div>

                                </div> <!-- end col-->

                            </div>
                            <!-- end row -->

                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    @if(!empty($item->id))
                                        <button id="buttonSubmit" type="submit"
                                                class="btn btn-success waves-effect waves-light m-1"><i
                                                    class="fe-check-circle mr-1"></i> @lang('purchaseReports.edit')
                                        </button>
                                    @else
                                        <button id="buttonSubmit" type="submit"
                                                class="btn btn-success waves-effect waves-light m-1"><i
                                                    class="fe-check-circle mr-1"></i> @lang('purchaseReports.create')
                                        </button>
                                    @endif

                                    <a href="{{route('purchaseReports.index')}}">
                                        <button type="button" class="btn btn-light waves-effect waves-light m-1"><i
                                                    class="fe-x mr-1"></i> @lang('purchaseReports.cancel')
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </form>


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
    <script src="{{ URL::asset('assets/js/pages/purchaseReport.init.js')}}"></script>
    <script>
    </script>
@endsection

