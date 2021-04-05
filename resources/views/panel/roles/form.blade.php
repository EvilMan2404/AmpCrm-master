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
                <form id="form" method="post" enctype="multipart/form-data"
                      action="{{route('roles.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="name">@lang('roles.name')</label>
                                        <input type="text" id="name" name="name"
                                               class="form-control @error('name') is-invalid @enderror" required
                                               data-parsley-error-message="@lang('roles.errors.required')"
                                               placeholder="@lang('roles.name')"
                                               value="{{  old('name',$item->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="guard_name">@lang('roles.guard_name')</label>
                                        <input type="text" id="guard_name" name="guard_name"
                                               class="form-control @error('guard_name') is-invalid @enderror" required
                                               data-parsley-error-message="@lang('roles.errors.required')"
                                               placeholder="@lang('roles.guard_name')"
                                               value="{{  old('guard_name',$item->guard_name) }}">
                                        @error('guard_name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                            <!-- end card-body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="card">
                        <div class="card-header">
                            @lang('roles.permissions')
                            @error('permissions')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                            @error('permissions.*')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group row">
                                        @foreach($permissions as $permission)
                                            <div class="col-xl-4">
                                                <div class="checkbox checkbox-primary mb-2">
                                                    <input id="permission-{{$permission->id}}" type="checkbox"
                                                           name="permissions[]" value="{{$permission->id}}"
                                                           @if(in_array($permission->id,old('permissions',$rolePermissions)))
                                                           checked=""
                                                            @endif
                                                    >
                                                    <label for="permission-{{$permission->id}}">
                                                        {{$permission->name}}
                                                    </label>
                                                    <button type="button" class="btn p-0"
                                                            title="{{$permission->desc}}"
                                                            data-plugin="tippy" data-tippy-placement="top">
                                                        <i class="fas fas fa-question-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                            <!-- end card-body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </form>
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        @if(!empty($item->id))
                            <button type="button" id="buttonSave" class="btn btn-success waves-effect waves-light m-1">
                                <i
                                        class="fe-check-circle mr-1"></i> @lang('roles.edit')
                            </button>
                        @else
                            <button type="button" id="buttonSave" class="btn btn-success waves-effect waves-light m-1">
                                <i
                                        class="fe-check-circle mr-1"></i> @lang('roles.create')
                            </button>
                        @endif
                        <button type="button" onclick="location='{{route('roles.index')}}'"
                                class="btn btn-light waves-effect waves-light m-1"><i
                                    class="fe-x mr-1"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>
            <!-- end row-->

        </div> <!-- container -->


        @endsection

        @section('script')
            <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
            <!-- Plugin js-->
            <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
            <script src="{{ URL::asset('assets/libs/tippy-js/tippy-js.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/pages/roles.init.js')}}"></script>
@endsection
