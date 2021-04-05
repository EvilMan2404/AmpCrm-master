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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="companyForm" method="post" enctype="multipart/form-data"
                              action="{{route('company.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">

                                    <div class="form-group">
                                        <label for="companyName">@lang('company.name')</label>
                                        <input type="text" id="companyName" name="name"
                                               class="form-control @error('name') is-invalid @enderror" required
                                               data-parsley-required-message="@lang('company.errors.name')"
                                               placeholder="@lang('catalog.name')"
                                               value="{{  old('name',$item->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">@lang('company.description')</label>
                                        <textarea name="description"
                                                  class="form-control @error('description') is-invalid @enderror"
                                                  data-parsley-required-message="@lang('company.errors.description')"

                                                  placeholder="@lang('company.description')">{{old('description',$item->description)}}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="url">@lang('company.website')</label>
                                        <div>
                                            <input id="url" parsley-type="url" name="website" type="url"
                                                   class="form-control @error('website') is-invalid @enderror"
                                                   placeholder="@lang('company.website')"
                                                   data-parsley-required-message="@lang('company.errors.website')"
                                                   data-parsley-type-message="@lang('company.errors.website')"

                                                   value="{{  old('website',$item->website) }}">
                                        </div>
                                        @error('website')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">@lang('company.email')</label>
                                        <div>
                                            <input id="email" parsley-type="email" name="email" type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   data-parsley-required-message="@lang('company.errors.email')"
                                                   data-parsley-email-message="@lang('company.errors.email')"
                                                   placeholder="@lang('company.email')"
                                                   value="{{  old('email',$item->email) }}"/>
                                        </div>
                                        @error('email')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label
                                                for="phone">@lang('company.phone')</label>
                                        <div>
                                            <input id="phone" name="phone" type="tel"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   data-parsley-required-message="@lang('company.errors.phone')"
                                                   required placeholder="@lang('company.phone')"
                                                   value="{{  old('phone',$item->phone) }}"/>
                                        </div>
                                        @error('phone')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-xl-4 mb-3">
                                        <div class="attach-logo">
                                            <div class="form-group">
                                                <label class="label">
                                                    @if(!empty($item->id) && $item->files)
                                                        <img class="img-fluid" src="/images/{{$item->files->file}}"
                                                             alt="{{$item->files->name}}"/>
                                                    @else
                                                        <i class="material-icons">attach_file</i>
                                                        <span class="title">Загрузить логотип</span>
                                                    @endif
                                                    <input type="file" name="logo" id="gallery-photo-add"
                                                           value="{{  old('logo') }}"
                                                           data-parsley-required-message="@lang('company.errors.logo')"
                                                    >
                                                </label>
                                            </div>
                                        </div>
                                        @error('logo')
                                        <div class="invalid-feedback" style="display:block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                        @if (session('logo'))
                                            <div class="invalid-feedback" style="display:block;">
                                                <strong>{{ session('logo')}}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- end col-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="country">@lang('company.billing_address_country')</label>
                                        <select id="country" name="billing_address_country"
                                                class="form-control  @error('billing_address_country') is-invalid @enderror"
                                                data-toggle="select2">
                                            @if(!old('billing_address_country',$item->billing_address_country))
                                                <option disabled selected>@lang('company.form.choose_country')</option>
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
                                                for="billing_address_state">@lang('company.billing_address_state')</label>
                                        <div>
                                            <input id="billing_address_state" name="billing_address_state" type="text"
                                                   class="@error('billing_address_state') is-invalid @enderror form-control"
                                                   placeholder="@lang('company.billing_address_state')"
                                                   data-parsley-required-message="@lang('company.errors.billing_address_state')"
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
                                        <label for="billing_address_city">@lang('company.billing_address_city')</label>
                                        <div>
                                            <select id="billing_address_city" name="billing_address_city"
                                                    class="@error('billing_address_city') is-invalid @enderror form-control"
                                                    data-toggle="select2">
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
                                                for="billing_address_street">@lang('company.billing_address_street')</label>
                                        <div>
                                            <input id="billing_address_street" name="billing_address_street" type="text"
                                                   class="form-control @error('billing_address_street') is-invalid @enderror"
                                                   placeholder="@lang('company.billing_address_street')"
                                                   data-parsley-required-message="@lang('company.errors.billing_address_street')"
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
                                                for="billing_address_postal_code">@lang('company.billing_address_postal_code')</label>
                                        <div>
                                            <input id="billing_address_postal_code" name="billing_address_postal_code"
                                                   type="text"
                                                   class="form-control  @error('billing_address_postal_code') is-invalid @enderror"
                                                   placeholder="@lang('company.billing_address_postal_code')"
                                                   data-parsley-required-message="@lang('company.errors.billing_address_postal_code')"
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
                                                for="billing_address">@lang('company.billing_address')</label>
                                        <div>
                                            <input id="billing_address" name="billing_address" type="text"
                                                   class="form-control @error('billing_address') is-invalid @enderror"
                                                   placeholder="@lang('company.billing_address')"
                                                   data-parsley-required-message="@lang('company.errors.billing_address')"
                                                   value="{{old('billing_address',$item->billing_address)}}"/>
                                        </div>
                                        @error('billing_address')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label
                                                for="shipping_address">@lang('company.shipping_address')</label>
                                        <div>
                                            <input id="shipping_address" name="shipping_address" type="text"
                                                   class="form-control @error('shipping_address') is-invalid @enderror"
                                                   placeholder="@lang('company.shipping_address')"
                                                   data-parsley-required-message="@lang('company.errors.shipping_address')"
                                                   value="{{old('shipping_address',$item->shipping_address)}}"/>
                                        </div>
                                        @error('shipping_address')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label
                                                for="payment_info">@lang('company.payment_info')</label>
                                        <div>
                                            <input id="payment_info" name="payment_info" type="text"
                                                   class="@error('payment_info') is-invalid @enderror form-control"
                                                   placeholder="@lang('company.payment_info')"
                                                   data-parsley-required-message="@lang('company.errors.payment_info')"
                                                   value="{{old('payment_info',$item->payment_info)}}"/>
                                        </div>
                                        @error('payment_info')
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
                                                    class="fe-check-circle mr-1"></i> @lang('company.edit')
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                    class="fe-check-circle mr-1"></i> @lang('company.create')
                                        </button>
                                    @endif
                                    <button type="button" onclick="location='{{route('company.index')}}'"
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
            <!-- Summernote js -->
            <script src="{{ URL::asset('assets/libs/summernote/summernote.min.js')}}"></script>
            <!-- Plugin js-->
            <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>

            <!-- Plugins js -->
            <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
            <script src="{{ URL::asset('assets/libs/dropify/dropify.min.js')}}"></script>
            <script>

                $('#country').on('change', initializeSelect2);

                function initializeSelect2() {
                    var value = $('#country').children("option:selected").val();
                    value = parseInt(value);
                    $("#billing_address_city").val(null);
                    $('#billing_address_city').select2({
                        ajax: {
                            url: '{{ route('request.getCities') }}',
                            type: 'POST',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: function (params) {
                                return {
                                    q: params.term, // search term
                                    page: params.page,
                                    country: value,
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
                        placeholder: '@lang('company.search.searchCity')',
                        language: {
                            // You can find all of the options in the language files provided in the
                            // build. They all must be functions that return the string that should be
                            // displayed.
                            inputTooShort: function inputTooShort() {
                                return '@lang('company.search.start')';
                            },
                            searching: function searching() {
                                return '@lang('company.search.searching')';
                            },
                            noResults: function noResults() {
                                return '@lang('company.search.noResults')';
                            }
                        }
                    });
                }

                $(document).ready(function () {
                    $('[data-toggle="select2"]').select2();
                    initializeSelect2()
                    @if(Route::is('company.create'))
                    $('#billing_address_city').select2({
                        placeholder: '{{__('company.form.choose_country_first')}}',
                        language: {
                            // You can find all of the options in the language files provided in the
                            // build. They all must be functions that return the string that should be
                            // displayed.
                            inputTooShort: function inputTooShort() {
                                return '@lang('company.search.start')';
                            },
                            searching: function searching() {
                                return '@lang('company.search.searching')';
                            },
                            noResults: function noResults() {
                                return '@lang('company.search.noResults')';
                            }
                        }
                    });
                    @endif
                    @if(old('billing_address_city',$item->billing_address_city) && !$errors->has('billing_address_city') && !$errors->has('billing_address_country'))
                    @if(Route::is('company.edit'))
                    var option = '<option selected="selected"' +
                        'value="{{$item->billing_address_city}}">{{$item->citiesRelation->title}}</option>';
                    @else
                    var option = '<option selected="selected"' +
                        'value="{{old('billing_address_city')}}">{{App\Models\City::find(old('billing_address_city'))->title}}</option>';
                    @endif
                    $('#billing_address_city').append(option);
                    @endif
                });

                $(function () {
                    // Multiple images preview in browser
                    var imagesPreview = function (input, placeToInsertImagePreview) {

                        if (input.files) {
                            var filesAmount = input.files.length;

                            for (i = 0; i < filesAmount; i++) {
                                var reader = new FileReader();

                                reader.onload = function (event) {
                                    $($.parseHTML('<img>')).attr('src', event.target.result).attr('class', 'img-fluid').appendTo(placeToInsertImagePreview);
                                }

                                reader.readAsDataURL(input.files[i]);
                            }
                        }

                    };

                    $('#gallery-photo-add').on('change', function () {
                        $('label.label img').remove();
                        $('.material-icons').hide();
                        $('span.title').hide();
                        imagesPreview(this, 'label.label');
                    });
                });
            </script>
@endsection
