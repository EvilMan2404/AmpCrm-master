@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/summernote/summernote.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Plugins css -->
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- App css -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <form class="companyForm" method="post" enctype="multipart/form-data"
                              action="{{route('lots.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                            @csrf
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label for="name">@lang('lots.name')</label>
                                        <input type="text" id="name" name="name"
                                               class="form-control @error('name') is-invalid @enderror" required
                                               data-parsley-required-message="@lang('lots.errors.name')"
                                               placeholder="@lang('lots.name')"
                                               value="{{  old('name',$item->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- end col-->
                                <div class="col-xl-4">
                                    <div id="company_error" class="form-group">
                                        <label for="company">@lang('lots.company')</label>
                                        <select id="company" name="company_id"
                                                class="form-control  @error('company_id') is-invalid @enderror"
                                                data-parsley-errors-container="#company_error"
                                                data-parsley-required-message="@lang('lots.errors.company')"
                                                required
                                                data-toggle="select2">
                                            @if(!old('company_id',$item->company_id))
                                                <option disabled selected>@lang('lots.form.company')</option>
                                            @endif
                                        </select>
                                        @error('company_id')
                                        <div class="invalid-feedback" style="display:block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div id="assigned_user_container" class="form-group">
                                        <label for="assigned_user">@lang('lots.moderator')</label>
                                        <select id="assigned_user" name="assigned_user"
                                                class="form-control  @error('assigned_user') is-invalid @enderror"
                                                data-parsley-errors-container="#assigned_user_container"
                                                @if(!empty($item->id) && Auth::id() !== $item->user_id)
                                                disabled
                                                @endif
                                                data-toggle="select2">
                                            @if(!old('assigned_user ',$item->assigned_user))
                                                <option disabled selected>@lang('lots.form.moderator')</option>
                                            @endif
                                        </select>
                                        @if(!empty($item->id) && Auth::id() !== $item->user_id)
                                            <div class="invalid-feedback" style="display:block;">
                                                <strong>{{ __('lots.errors.onlyForOwner') }}</strong>
                                            </div>
                                        @endif
                                        @error('assigned_user')
                                        <div class="invalid-feedback" style="display:block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="description">@lang('lots.description')</label>
                                        <textarea name="description"
                                                  class="form-control @error('description') is-invalid @enderror"
                                                  placeholder="@lang('company.description')">{{old('description',$item->description)}}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label for="pt">@lang('lots.pt')</label>
                                        <input id="pt" name="pt_weight"
                                               @if($inPurchase) disabled @endif
                                               class="form-control @error('pt_weight') is-invalid @enderror"
                                               data-parsley-type="number"
                                               data-parsley-error-message="@lang('lots.errors.pt')"
                                               data-parsley-required
                                               placeholder="@lang('lots.pt')"
                                               type="text"
                                               value="{{  old('pt_weight',$item->pt_weight) }}">
                                        @error('pt_weight')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="r_pt">@lang('lots.r_pt')</label>
                                        <input type="text" id="r_pt" name="pt_rate"
                                               @if($inPurchase) disabled @endif
                                               data-parsley-type="number"
                                               class="form-control @error('pt_rate') is-invalid @enderror"
                                               data-parsley-error-message="@lang('lots.errors.r_pt')"
                                               required
                                               placeholder="@lang('lots.r_pt')"
                                               value="{{  old('pt_rate',$item->pt_rate) }}">
                                        @error('pt_rate')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="s_pt">@lang('lots.s_pt')</label>
                                        <input id="s_pt" type="text" disabled value="0" class="form-control">

                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label for="pd">@lang('lots.pd')</label>
                                        <input type="text" id="pd" name="pd_weight"
                                               @if($inPurchase) disabled @endif
                                               data-parsley-type="number"
                                               class="form-control @error('pd_weight') is-invalid @enderror" required
                                               data-parsley-error-message="@lang('lots.errors.pd')"
                                               placeholder="@lang('lots.pd')"
                                               value="{{  old('pd_weight',$item->pd_weight) }}">
                                        @error('pd_weight')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="r_pd">@lang('lots.r_pd')</label>
                                        <input type="text" id="r_pd" name="pd_rate"
                                               @if($inPurchase) disabled @endif
                                               data-parsley-type="number"
                                               class="form-control @error('pd_rate') is-invalid @enderror" required
                                               data-parsley-error-message="@lang('lots.errors.r_pd')"
                                               placeholder="@lang('lots.r_pd')"
                                               value="{{  old('pd_rate',$item->pd_rate) }}">
                                        @error('pd_rate')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="s_pd">@lang('lots.s_pd')</label>
                                        <input id="s_pd" type="text" disabled value="0" class="form-control">

                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label for="rh">@lang('lots.rh')</label>
                                        <input type="text" id="rh" name="rh_weight"
                                               data-parsley-type="number"
                                               @if($inPurchase) disabled @endif
                                               class="form-control @error('rh_weight') is-invalid @enderror" required
                                               data-parsley-error-message="@lang('lots.errors.rh')"
                                               placeholder="@lang('lots.rh')"
                                               value="{{  old('rh_weight',$item->rh_weight) }}">
                                        @error('rh_weight')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="r_rh">@lang('lots.r_rh')</label>
                                        <input type="text" id="r_rh" name="rh_rate"
                                               data-parsley-type="number"
                                               @if($inPurchase) disabled @endif
                                               class="form-control @error('rh_rate') is-invalid @enderror" required
                                               data-parsley-error-message="@lang('lots.errors.r_rh')"
                                               placeholder="@lang('lots.r_rh')"
                                               value="{{  old('rh_rate',$item->rh_rate) }}">
                                        @error('rh_rate')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="s_rh">@lang('lots.s_rh')</label>
                                        <input type="text" id="s_rh" disabled value="0" class="form-control">

                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    @if(!empty($item->id))
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                    class="fe-check-circle mr-1"></i> @lang('lots.edit')
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                    class="fe-check-circle mr-1"></i> @lang('lots.create')
                                        </button>
                                    @endif
                                    <button type="button" onclick="location='{{route('lots.index')}}'"
                                            class="btn btn-light waves-effect waves-light m-1"><i
                                                class="fe-x mr-1"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </form> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>
            @if(Route::is('lots.edit'))
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            История изменений
                        </div>
                        <div class="card-body">
                            <div class="border-bottom pt-2 pb-2">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet aspernatur eius est ipsam
                                iure quidem quisquam quos similique tempore vero. Animi at enim ipsam labore molestias
                                neque
                                quia ratione sit?
                            </div>
                            <div class="border-bottom mt-1 pt-2 pb-2">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet aspernatur eius est ipsam
                                iure quidem quisquam quos similique tempore vero. Animi at enim ipsam labore molestias
                                neque
                                quia ratione sit?
                            </div>
                        </div>
                    </div>
                </div>
        @endif
        <!-- end row-->

        </div> <!-- container -->

    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <!-- Plugin js-->
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/dropify/dropify.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            initializeSelect2Companies()
            initializeSelect2Users()
            putInputValue('pt')
            putInputValue('pd')
            putInputValue('rh')
            @if(old('company_id',$item->company_id) && !$errors->has('company_id'))
            @if(Route::is('lots.edit'))
            var option = '<option selected="selected"' +
                'value="{{$item->company_id}}">{{$item->company->name}}</option>';
            @else
            var option = '<option selected="selected"' +
                'value="{{old('company_id')}}">{{App\Models\Company::find(old('company_id'))->name}}</option>';
            @endif
            $('#company').append(option);
            @endif

            @if(old('assigned_user',$item->company_id) && !$errors->has('assigned_user'))
            @if(Route::is('lots.edit'))
            var option = '<option selected="selected"' +
                'value="{{$item->assigned_user}}">{{$item->assigned->fullname()}} | {{$item->assigned->email}}</option>';
            @else
            var option = '<option selected="selected"' +
                'value="{{old('assigned_user')}}">{{App\Models\User::find(old('assigned_user'))->fullname()}} | {{App\Models\User::find(old('assigned_user'))->email}}</option>';
            @endif
            $('#assigned_user').append(option);
            @endif
        });

        function initializeSelect2Companies() {
            $('#company').select2({
                ajax: {
                    url: '{{ route('request.getCompanies') }}',
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                },
                placeholder: '@lang('lots.lookForCompany')',
                minimumInputLength: 1,
            });
        }

        function initializeSelect2Users() {
            $('#assigned_user').select2({
                ajax: {
                    url: '{{ route('request.getUsers') }}',
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                },
                placeholder: '@lang('lots.lookForUsers')',
                minimumInputLength: 1,
            });
        }


        $('#pt, #r_pt,#pd,#r_pd,#rh,#r_rh').on('change', function () {
            var $this = $(this);
            var string = 'r_';
            var element_id = '';
            if ($this.attr('id').indexOf(string) !== -1) {
                element_id = $this.attr('id').slice(-2)
            } else {
                element_id = $this.attr('id');
            }
            putInputValue(element_id);
        });

        function putInputValue(id) {
            var element = $('#' + id);
            var element_rate = $('#r_' + id);
            var summInput = $('#s_' + id);
            summInput.val('');
            var result = 0;
            if (element.val() && element_rate.val() && $.isNumeric(element.val()) && $.isNumeric(element_rate.val())) {
                result = (parseFloat(element.val()) * parseFloat(element_rate.val())).toFixed(8);
            } else {
                result = '{{__('lots.errors.notValidData')}}';
            }
            summInput.val(result);
        }

    </script>
@endsection
