<div class="modal fade" id="course-settings" tabindex="-1" role="dialog" aria-labelledby="course-settings"
     style=""
     aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">@lang('catalog.course_settings.title_modal')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="post" id="course-form"
                      action="{{route('catalog.course.settings')}}">
                    @csrf
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="pt">@lang('catalog.course_settings.pt')</label>
                                <input data-parsley-type="number" data-parsley-required
                                       data-parsley-error-message="@lang('catalog.course_settings.errors.common')"
                                       type="text"
                                       id="pt" name="pt" value="{{ old('pt',session('pt')) ?? 100 }}"
                                       class="@error('pt') is-invalid @enderror form-control"
                                       placeholder="@lang('catalog.course_settings.pt')">
                                @error('pt')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div> <!-- end col-->

                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="pd">@lang('catalog.course_settings.pd')</label>
                                <input data-parsley-type="number" data-parsley-required
                                       data-parsley-error-message="@lang('catalog.course_settings.errors.common')"
                                       type="text"
                                       id="pd" name="pd" value="{{ old('pd',session('pd')) ?? 100 }}"
                                       class="@error('pd') is-invalid @enderror form-control"
                                       placeholder="@lang('catalog.course_settings.pd')">
                                @error('pd')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div> <!-- end col-->

                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="rh">@lang('catalog.course_settings.rh')</label>
                                <input data-parsley-type="number" data-parsley-required
                                       data-parsley-error-message="@lang('catalog.course_settings.errors.common')"
                                       type="text"
                                       id="rh" name="rh" value="{{ old('rh',session('rh')) ?? 100 }}"
                                       class="@error('rh') is-invalid @enderror form-control"
                                       placeholder="@lang('catalog.course_settings.rh')">
                                @error('rh')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="d_pt">@lang('catalog.course_settings.d_pt')</label>
                                <input required data-parsley-type="number"
                                       data-parsley-error-message="@lang('catalog.course_settings.errors.common')"
                                       type="text"
                                       id="d_pt" name="d_pt" value="{{ old('d_pt',session('d_pt')) ?? 100 }}"
                                       class="@error('d_pt') is-invalid @enderror form-control"
                                       placeholder="@lang('catalog.course_settings.d_pt')">
                                @error('d_pt')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div> <!-- end col-->

                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="d_pd">@lang('catalog.course_settings.d_pd')</label>
                                <input data-parsley-required data-parsley-type="number"
                                       data-parsley-error-message="@lang('catalog.course_settings.errors.common')"
                                       type="text"
                                       id="d_pd" name="d_pd" value="{{ old('d_pd',session('d_pd')) ?? 100 }}"
                                       class="@error('d_pd') is-invalid @enderror form-control"
                                       placeholder="@lang('catalog.course_settings.d_pd')">
                                @error('d_pd')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div> <!-- end col-->

                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="d_rh">@lang('catalog.course_settings.d_rh')</label>
                                <input data-parsley-required data-parsley-type="number"
                                       data-parsley-error-message="@lang('catalog.course_settings.errors.common')"
                                       type="text"
                                       id="d_rh" name="d_rh" value="{{ old('d_rh',session('d_rh')) ?? 100 }}"
                                       class="@error('d_rh') is-invalid @enderror form-control"
                                       placeholder="@lang('catalog.course_settings.d_rh')">
                                @error('d_rh')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div> <!-- end col-->
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button id="" type="submit"
                                    class="btn btn-success waves-effect waves-light m-1"><i
                                        class="fe-check-circle mr-1"></i> @lang('catalog.course_settings.submit')
                            </button>
                            <a href="{{route('catalog.course.clear')}}">
                                <button id="" type="button"
                                        class="btn btn-danger waves-effect waves-light m-1"><i
                                            class="fe-check-circle mr-1"></i> @lang('catalog.unset')
                                </button>
                            </a>


                        </div>
                    </div>
                    <!-- end row -->
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@if($errors->has('pt') || $errors->has('pd') || $errors->has('rh') || $errors->has('d_pt') || $errors->has('d_pd') ||  $errors->has('d_rh') || $errors->has('total'))
    <div id="show_modal" data-value="true"></div>
@else
    <div id="show_modal" data-value="false"></div>
@endif