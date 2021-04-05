@extends('layouts.master')
@section('css')
    <!-- Plugins css -->
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)


        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" id="form"
                              action="{{route('catalog.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                            @csrf
                            @if(!empty($success))
                                <div class="alert alert-success">{{$success}}</div>
                            @endif
                            @error('files')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="  form-group">
                                        <label for="catalogName">@lang('catalog.name')</label>
                                        <input data-parsley-required
                                               data-parsley-required-message="@lang('catalog.errors.name')" type="text"
                                               id="catalogName" name="name" value="{{old('name',$item->name)}}"
                                               class="@error('name') is-invalid @enderror form-control"
                                               placeholder="@lang('catalog.name')">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="project-overview">@lang('catalog.description')</label>
                                        <textarea class="form-control" id="project-overview" name="description" rows="5"
                                                  placeholder="@lang('catalog.description')">{{old('description',$item->description)}}</textarea>
                                    </div>


                                </div> <!-- end col-->

                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <!-- Date View -->
                                            <div class="form-group">
                                                <label style="display: block;">@lang('catalog.car_brand')</label>

                                                <select class="@error('carbrand') is-invalid @enderror "
                                                        name="carbrand"
                                                        data-parsley-required-message="@lang('catalog.errors.carbrand')"
                                                        data-parsley-required class="form-control"
                                                        data-toggle="select2">
                                                    @foreach($brand as $value)
                                                        <option @if(old('car_brand',$item->car_brand) === $value->id) selected="selected"
                                                                @endif value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('carbrand')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <!-- Date View -->
                                            <div class="form-group">
                                                <label>@lang('catalog.serial_number')</label>
                                                <input name="serial_number" data-parsley-required
                                                       data-parsley-required-message="@lang('catalog.errors.serial_number')"
                                                       type="text"
                                                       value="{{old('serial_number',$item->serial_number)}}"
                                                       class="@error('serial_number') is-invalid @enderror form-control"
                                                       placeholder="@lang('catalog.serial_number')">
                                                @error('serial_number')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <!-- Date View -->
                                            <div class="form-group">
                                                <label>@lang('catalog.pt')</label>
                                                <input name="pt" data-parsley-type="number"
                                                       data-parsley-number-message="@lang('catalog.errors.pt')"
                                                       data-parsley-required-message="@lang('catalog.errors.pt')"
                                                       data-parsley-required
                                                       value="{{old('pt',$item->pt)}}"
                                                       type="text"
                                                       class="@error('pt') is-invalid @enderror form-control"
                                                       placeholder="@lang('catalog.pt')">
                                                @error('pt')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <!-- Date View -->
                                            <div class="form-group">
                                                <label>@lang('catalog.pd')</label>
                                                <input name="pd" data-parsley-type="number"
                                                       data-parsley-number-message="@lang('catalog.errors.pd')"
                                                       data-parsley-required-message="@lang('catalog.errors.pd')"
                                                       data-parsley-required
                                                       value="{{old('pd',$item->pd)}}"
                                                       type="text"
                                                       class="@error('pd') is-invalid @enderror form-control"
                                                       placeholder="@lang('catalog.pd')">
                                                @error('pd')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <!-- Date View -->
                                            <div class="form-group">
                                                <label>@lang('catalog.rh')</label>
                                                <input name="rh" data-parsley-type="number"
                                                       data-parsley-number-message="@lang('catalog.errors.rh')"
                                                       data-parsley-required-message="@lang('catalog.errors.rh')"
                                                       data-parsley-required
                                                       value="{{old('rh',$item->rh)}}"
                                                       type="text"
                                                       class="@error('rh') is-invalid @enderror form-control"
                                                       placeholder="@lang('catalog.rh')">
                                                @error('rh')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <!-- Date View -->
                                            <div class="form-group">
                                                <label>@lang('catalog.weight')</label>
                                                <input name="weight" data-parsley-type="number"
                                                       data-parsley-number-message="@lang('catalog.errors.weight')"
                                                       data-parsley-required-message="@lang('catalog.errors.weight')"
                                                       data-parsley-required
                                                       value="{{old('weight',$item->weight)}}"
                                                       type="text"
                                                       class="@error('weight') is-invalid @enderror form-control"
                                                       placeholder="@lang('catalog.weight')">
                                                @error('weight')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col-->
                            </div>
                            <!-- end row -->
                            <input type="hidden" name="files" value="{{$item->listFiles}}" id="listImages">

                        </form>
                        @if(!empty($item->files))
                            @foreach($item->files as $file)
                                <input type=hidden data-obj-id="{{$item->id}}" data-dropify-id="{{$file->id}}"
                                       class="dropify"
                                       data-show-remove="true" data-default-file="/images/{{$file->file}}"/>
                            @endforeach
                        @endif
                        <form action="{{route('catalog.upload')}}" method="post" class="dropzone"
                              id="myAwesomeDropzone">
                            @csrf
                            <div class="fallback">
                                <input name="file" type="file"/>
                            </div>

                            <div class="dz-message needsclick">
                                <i class="h1 text-muted dripicons-cloud-upload"></i>
                            </div>
                        </form>

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                @if(!empty($item->id))
                                    <button id="buttonSubmit" type="button"
                                            class="btn btn-success waves-effect waves-light m-1"><i
                                                class="fe-check-circle mr-1"></i> @lang('catalog.edit')
                                    </button>
                                @else
                                    <button id="buttonSubmit" type="button"
                                            class="btn btn-success waves-effect waves-light m-1"><i
                                                class="fe-check-circle mr-1"></i> @lang('catalog.create')
                                    </button>
                                @endif

                                <a href="{{route('catalog.index')}}">
                                    <button type="button" class="btn btn-light waves-effect waves-light m-1"><i
                                                class="fe-x mr-1"></i> @lang('catalog.cancel')
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


@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/dropify/dropify.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/catalog.init.js')}}"></script>


@endsection
