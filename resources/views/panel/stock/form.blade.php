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
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="form" method="post" enctype="multipart/form-data"
                              action="{{route('stock.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12 mt-2 mb-4">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>@lang('purchase.name')</th>
                                                <th>@lang('purchase.owner')</th>
                                                <th>@lang('purchase.pt')</th>
                                                <th>@lang('purchase.pd')</th>
                                                <th>@lang('purchase.rh')</th>

                                                <th>@lang('purchase.pt-course')</th>
                                                <th>@lang('purchase.pd-course')</th>
                                                <th>@lang('purchase.rh-course')</th>

                                                <th>@lang('purchase.total')</th>
                                            </tr>
                                            </thead>
                                            <tbody id="purchase-body">
                                            <tr class="table-info">

                                                <td colspan="6" class="font-weight-bold">Усредненный курс</td>
                                                <td class=" font-weight-bold" id="pt-rate">0</td>
                                                <td class=" font-weight-bold" id="pd-rate">0</td>
                                                <td class=" font-weight-bold" id="rh-rate">0</td>
                                                <td class=" font-weight-bold"></td>

                                            </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div> <!-- end col-->
                                <div class="col-xl-4">

                                    <div class="form-group">
                                        <label for="name">@lang('stock.name')</label>
                                        <input type="text" id="name" name="name"
                                               class="form-control @error('name') is-invalid @enderror" required
                                               data-parsley-error-message="@lang('stock.errors.name')"
                                               placeholder="@lang('stock.name')"
                                               value="{{  old('name',$item->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="date">@lang('stock.date')</label>
                                        <input type="date" id="date" name="date"
                                               class="form-control @error('name') is-invalid @enderror" required
                                               data-parsley-error-message="@lang('stock.errors.date')"
                                               placeholder="@lang('stock.date')"
                                               value="{{  old('date',$item->date) }}">
                                        @error('date')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div id="owner">
                                        <div class="radio radio-success mb-2">
                                            <input type="radio" name="owner" id="owner_user"
                                                   data-route="{{route('request.getUsers')}}"
                                                   @if(old('owner',$item->owner) === \App\Models\User::class || !$item->id || !$item->owner) checked
                                                   @endif
                                                   value="{{\App\Models\User::class}}">
                                            <label for="owner_user">
                                                @lang('purchase.owner_user')
                                            </label>
                                        </div>
                                        <div class="radio radio-info mb-2">
                                            <input type="radio" name="owner" id="owner_client"
                                                   data-route="{{route('request.getClients')}}"
                                                   @if(old('owner',$item->owner) === \App\Models\Clients::class) checked
                                                   @endif
                                                   value="{{\App\Models\Clients::class}}">
                                            <label for="owner_client">
                                                @lang('purchase.owner_client')
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                                for="assigned_user_id">@lang('stock.user_id')</label>
                                        <div id="user_id_container">
                                            <select id="user_id" name="user_id"
                                                    class="form-control  @error('user_id') is-invalid @enderror"
                                                    data-searching="@lang('stock.search.searching')"
                                                    data-no-results="@lang('stock.search.noResults')"
                                                    data-start="@lang('stock.search.start')"
                                                    data-placeholder="@lang('stock.search.startSearching')"
                                                    data-parsley-errors-container="#user_id_container"
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

                                <div class="col-xl-4">

                                    <div class="form-group">
                                        <label for="ceramic">@lang('stock.ceramic')</label>
                                        <input type="text" id="ceramic" name="weight_ceramics"
                                               class="form-control @error('weight_ceramics') is-invalid @enderror"
                                               required
                                               data-parsley-error-message="@lang('stock.errors.ceramic')"
                                               placeholder="@lang('stock.ceramic')"
                                               data-parsley-type="number"
                                               disabled
                                               style="cursor:not-allowed;"
                                               value="{{  old('weight_ceramics',$item->weight_ceramics) }}">
                                        @error('weight_ceramics')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="weight_dust">@lang('stock.dust')</label>
                                        <input type="text" id="weight_dust" name="weight_dust"
                                               class="form-control @error('weight_dust') is-invalid @enderror" required
                                               data-parsley-error-message="@lang('stock.errors.dust')"
                                               placeholder="@lang('stock.dust')"
                                               data-parsley-type="number"
                                               value="{{  old('weight_dust',$item->weight_dust) }}">
                                        @error('weight_dust')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="metallic">@lang('stock.metallic')</label>
                                        <input type="text" id="metallic" name="metallic"
                                               class="form-control @error('metallic') is-invalid @enderror" required
                                               data-parsley-error-message="@lang('stock.errors.metallic')"
                                               placeholder="@lang('stock.metallic')"
                                               data-parsley-type="number"
                                               value="{{  old('metallic',$item->metallic) }}">
                                        @error('metallic')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="catalyst">@lang('stock.catalyst')</label>
                                        <input type="text" id="catalyst" name="catalyst"
                                               data-parsley-type="number"
                                               class="form-control @error('catalyst') is-invalid @enderror" required
                                               data-parsley-error-message="@lang('stock.errors.catalyst')"
                                               placeholder="@lang('stock.catalyst')"
                                               disabled
                                               style="cursor:not-allowed;"
                                               value="{{  old('catalyst',$item->catalyst) }}">
                                        @error('catalyst')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-4">

                                    <div class="form-group">
                                        <label for="purchases">@lang('stock.purchases')</label>
                                        <div>
                                            <select
                                                    data-info="{{route('request.getPurchaseInfo')}}"
                                                    data-searching="@lang('stock.search.searching')"
                                                    data-no-results="@lang('stock.search.noResults')"
                                                    data-start="@lang('stock.search.start')"
                                                    data-placeholder="@lang('stock.search.purchases')"
                                                    data-url="{{route('request.getPurchase',['place' => 'stock'])}}"
                                                    multiple="multiple" id="purchases" name="purchases[]"
                                                    class="@error('purchases') is-invalid @enderror form-control"
                                                    data-toggle="select2">

                                                @foreach($purchasesInfo as $value)
                                                    <option selected="selected"
                                                            value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        @error('purchases')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                        @error('purchases.*')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror

                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label for="pt_purchase">@lang('stock.pt_purchase')</label>
                                                <input type="text" id="pt_purchase" name="pt_purchase"
                                                       class="form-control @error('pt_purchase') is-invalid @enderror"
                                                       required
                                                       data-parsley-type="number"
                                                       data-parsley-error-message="@lang('stock.errors.pt_purchase')"
                                                       placeholder="@lang('stock.pt_purchase')"
                                                       disabled
                                                       style="cursor:not-allowed;"
                                                       value="{{  old('pt_purchase',$item->pt_purchase) }}">
                                                @error('pt_purchase')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label for="pd_purchase">@lang('stock.pd_purchase')</label>
                                                <input type="text" id="pd_purchase" name="pd_purchase"
                                                       class="form-control @error('pd_purchase') is-invalid @enderror"
                                                       required
                                                       data-parsley-type="number"
                                                       data-parsley-error-message="@lang('stock.errors.pd_purchase')"
                                                       placeholder="@lang('stock.pd_purchase')"
                                                       disabled
                                                       style="cursor:not-allowed;"
                                                       value="{{  old('pd_purchase',$item->pd_purchase) }}">
                                                @error('pd_purchase')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label for="rh_purchase">@lang('stock.rh_purchase')</label>
                                                <input type="text" id="rh_purchase" name="rh_purchase"
                                                       class="form-control @error('rh_purchase') is-invalid @enderror"
                                                       required
                                                       data-parsley-type="number"
                                                       data-parsley-error-message="@lang('stock.errors.rh_purchase')"
                                                       placeholder="@lang('stock.rh_purchase')"
                                                       disabled
                                                       style="cursor:not-allowed;"
                                                       value="{{  old('rh_purchase',$item->rh_purchase) }}">
                                                @error('rh_purchase')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label for="pt_diff">@lang('stock.pt_diff')</label>
                                                <input type="text" id="pt_diff"
                                                       class="form-control"
                                                       placeholder="@lang('stock.pt_diff')"
                                                       disabled
                                                       style="cursor:not-allowed;"
                                                       value="{{($item->analysis_pt - $item->pt_purchase)}}">
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label for="pd_diff">@lang('stock.pd_diff')</label>
                                                <input type="text" id="pd_diff"
                                                       class="form-control"
                                                       placeholder="@lang('stock.pd_diff')"
                                                       disabled
                                                       style="cursor:not-allowed;"
                                                       value="{{($item->analysis_pd - $item->pd_purchase)}}">
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label for="rh_diff">@lang('stock.rh_diff')</label>
                                                <input type="text" id="rh_diff"
                                                       class="form-control"
                                                       placeholder="@lang('stock.rh_diff')"
                                                       disabled
                                                       style="cursor:not-allowed;"
                                                       value="{{($item->analysis_rh - $item->rh_purchase)}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6 mt-2 mb-1">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('stock.ceramic_analysis_pt')</th>
                                                <th>@lang('stock.ceramic_analysis_pd')</th>
                                                <th>@lang('stock.ceramic_analysis_rh')</th>
                                            </tr>
                                            </thead>
                                            <tbody id="ceramic-body">
                                            @foreach($ceramic as $key=>$value)
                                                <tr data-id="{{$key}}">
                                                    <th scope="row">
                                                        <button type="button" id="deleteRow"
                                                                class="btn btn-primary deleteRow"
                                                                data-row="{{$key}}">X
                                                        </button>
                                                    </th>
                                                    <td><input data-type="ceramic" data-m="pt"
                                                               class="form-control ceramic-input" type="text"
                                                               value="{{$value['pt']}}"
                                                               name="ceramic_analysis[{{$key}}][pt]"></td>
                                                    <td><input data-type="ceramic" data-m="pd"
                                                               class="form-control ceramic-input" type="text"
                                                               value="{{$value['pd']}}"
                                                               name="ceramic_analysis[{{$key}}][pd]"></td>
                                                    <td><input data-type="ceramic" data-m="rh"
                                                               class="form-control ceramic-input" type="text"
                                                               value="{{$value['rh']}}"
                                                               name="ceramic_analysis[{{$key}}][rh]"></td>
                                                </tr>
                                            @endforeach
                                            <tr class="table-info">

                                                <td colspan="" class="font-weight-bold">Усредненные значения</td>
                                                <td class="total_calc font-weight-bold" id="ceramic-pt-rate">0</td>
                                                <td class="total_calc font-weight-bold" id="ceramic-pd-rate">0</td>
                                                <td class="total_calc font-weight-bold" id="ceramic-rh-rate">0</td>

                                            </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div> <!-- end col-->
                                <div class="col-xl-6 mt-2 mb-3">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('stock.dust_analysis_pt')</th>
                                                <th>@lang('stock.dust_analysis_pd')</th>
                                                <th>@lang('stock.dust_analysis_rh')</th>
                                            </tr>
                                            </thead>
                                            <tbody id="dust-body">

                                            @foreach($dust as $key=>$value)
                                                <tr data-id="{{$key}}">
                                                    <th scope="row">
                                                        <button type="button" id="deleteRow"
                                                                class="btn btn-primary deleteRow"
                                                                data-row="{{$key}}">X
                                                        </button>
                                                    </th>
                                                    <td><input data-type="dust" data-m="pt"
                                                               class="form-control dust-input" type="text"
                                                               value="{{$value['pt']}}"
                                                               name="dust_analysis[{{$key}}][pt]"></td>
                                                    <td><input data-type="dust" data-m="pd"
                                                               class="form-control dust-input" type="text"
                                                               value="{{$value['pd']}}"
                                                               name="dust_analysis[{{$key}}][pd]"></td>
                                                    <td><input data-type="dust" data-m="rh"
                                                               class="form-control dust-input" type="text"
                                                               value="{{$value['rh']}}"
                                                               name="dust_analysis[{{$key}}][rh]"></td>
                                                </tr>
                                            @endforeach

                                            <tr class="table-info">

                                                <td colspan="" class="font-weight-bold">Усредненные значения</td>
                                                <td class="total_calc font-weight-bold" id="dust-pt-rate">0</td>
                                                <td class="total_calc font-weight-bold" id="dust-pd-rate">0</td>
                                                <td class="total_calc font-weight-bold" id="dust-rh-rate">0</td>

                                            </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div> <!-- end col-->
                                <div class="col-xl-2 m-auto">
                                    <button type="button" id="addNewAnalysis"
                                            class="btn btn-primary waves-effect btn-block waves-light"><i
                                                class="mdi mdi-plus"></i></button>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    @if(!empty($item->id))
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                    class="fe-check-circle mr-1"></i> @lang('stock.edit')
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                    class="fe-check-circle mr-1"></i> @lang('stock.create')
                                        </button>
                                    @endif
                                    <button type="button" onclick="location='{{route('stock.index')}}'"
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
            <script src="{{ URL::asset('assets/js/pages/stock.init.js')}}"></script>
@endsection
