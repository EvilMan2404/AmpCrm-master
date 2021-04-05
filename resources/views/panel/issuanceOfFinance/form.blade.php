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
                              action="{{route('issuanceOfFinance.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                            @csrf
                            @if(!empty($success))
                                <div class="alert alert-success">{{$success}}</div>
                            @endif
                            @error('files')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group row">
                                        <label for="name">@lang('issuanceOfFinance.name')</label>
                                        <input data-parsley-required
                                               data-parsley-required-message="@lang('issuanceOfFinance.errors.required')"
                                               type="text"
                                               id="name" name="name" value="{{old('name',$item->name)}}"
                                               class="@error('name') is-invalid @enderror form-control"
                                               placeholder="@lang('issuanceOfFinance.name')">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div> <!-- end col-->

                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label
                                                for="assigned_user_id">@lang('issuanceOfFinance.assigned_user')</label>
                                        <div id="user_container">
                                            <select id="user_id" name="user_id"
                                                    class="form-control  @error('user_id') is-invalid @enderror"

                                                    data-info="{{route('request.getUsers')}}"
                                                    data-searching="@lang('issuanceOfFinance.search.searching')"
                                                    data-no-results="@lang('issuanceOfFinance.search.noResults')"
                                                    data-start="@lang('issuanceOfFinance.search.start')"
                                                    data-placeholder="@lang('issuanceOfFinance.search.startSearchingUser')"
                                                    data-url="{{route('request.getUsers')}}"
                                                    data-parsley-required-message="@lang('issuanceOfFinance.errors.required')"
                                                    required
                                                    data-parsley-errors-container="#user_container"
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
                                </div> <!-- end col-->

                                <div class="col-xl-4">
                                    <div class="form-group row">
                                        <label for="amount">@lang('issuanceOfFinance.amount')</label>
                                        <input data-parsley-required
                                               data-parsley-error-message="@lang('issuanceOfFinance.errors.numeric')"
                                               data-parsley-type='number'
                                               type="text"
                                               id="amount" name="amount" value="{{old('amount',$item->amount)}}"
                                               class="@error('amount') is-invalid @enderror form-control"
                                               placeholder="@lang('issuanceOfFinance.amount')">
                                        @error('amount')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div> <!-- end col-->
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="description">@lang('issuanceOfFinance.description')</label>
                                        <textarea name="description" class="form-control"
                                                  id="description">{{old('description',$item->description)}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->


                        </form>


                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                @if(!empty($item->id))
                                    <button id="buttonSubmit" type="button"
                                            class="btn btn-success waves-effect waves-light m-1"><i
                                                class="fe-check-circle mr-1"></i> @lang('issuanceOfFinance.edit')
                                    </button>
                                @else
                                    <button id="buttonSubmit" type="button"
                                            class="btn btn-success waves-effect waves-light m-1"><i
                                                class="fe-check-circle mr-1"></i> @lang('issuanceOfFinance.create')
                                    </button>
                                @endif

                                <a href="{{route('issuanceOfFinance.index')}}">
                                    <button type="button" class="btn btn-light waves-effect waves-light m-1"><i
                                                class="fe-x mr-1"></i> @lang('issuanceOfFinance.cancel')
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
    <script src="{{ URL::asset('assets/js/pages/issuanceOfFinance.init.js')}}"></script>
    <script>
    </script>
@endsection
