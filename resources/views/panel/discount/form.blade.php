@extends('layouts.master')
@section('css')
@endsection
@section('content')
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)
        <div class="row">
            <div class="col-12">
                @if(session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <form class="companyForm" method="post" enctype="multipart/form-data"
                              action="{{route('discount.save')}}">
                            @csrf
                            <div class="row">
                                <div class="col-xl-3">

                                    <div class="form-group">
                                        <label for="pt_discount">@lang('discount.pt')</label>
                                        <input type="text" id="pt_discount" name="pt_discount"
                                               class="form-control @error('pt_discount') is-invalid @enderror" required
                                               data-parsley-error-message="@lang('discount.errors.error')"
                                               data-parsley-type='number'
                                               placeholder="{{ $discount->pt_discount }}"
                                               value="{{ old('pt_discount',$discount->pt_discount) }}">
                                        @error('pt_discount')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-3">

                                    <div class="form-group">
                                        <label for="pd_discount">@lang('discount.pd')</label>
                                        <input type="text" id="pd_discount" name="pd_discount"
                                               class="form-control @error('pd_discount') is-invalid @enderror" required
                                               data-parsley-error-message="@lang('discount.errors.error')"
                                               data-parsley-type='number'
                                               placeholder="{{ $discount->pd_discount }}"
                                               value="{{ old('pd_discount',$discount->pd_discount) }}">
                                        @error('pd_discount')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-3">

                                    <div class="form-group">
                                        <label for="rh_discount">@lang('discount.rh')</label>
                                        <input type="text" id="rh_discount" name="rh_discount"
                                               class="form-control @error('rh_discount') is-invalid @enderror" required
                                               data-parsley-error-message="@lang('discount.errors.error')"
                                               data-parsley-type='number'
                                               placeholder="{{ $discount->rh_discount }}"
                                               value="{{ old('rh_discount',$discount->rh_discount) }}">
                                        @error('rh_discount')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-3">

                                    <div class="form-group">
                                        <label for="purchase_discount">@lang('discount.total')</label>
                                        <input type="text" id="purchase_discount" name="purchase_discount"
                                               class="form-control @error('purchase_discount') is-invalid @enderror"
                                               required
                                               data-parsley-error-message="@lang('discount.errors.error')"
                                               data-parsley-type='number'
                                               placeholder="{{ $discount->purchase_discount }}"
                                               value="{{ old('purchase_discount',$discount->purchase_discount) }}">
                                        @error('purchase_discount')
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
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                    class="fe-check-circle mr-1"></i> @lang('discount.save')
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
