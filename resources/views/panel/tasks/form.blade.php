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
                        <form id="form" method="post" enctype="multipart/form-data"
                              action="{{route('tasks.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                            @csrf
                            <div class="row">
                                <div class="col-xl-4">

                                    <div class="form-group">
                                        <label for="name">@lang('tasks.name')</label>
                                        <input type="text" id="name" name="name"
                                               class="form-control @error('name') is-invalid @enderror" required
                                               data-parsley-required-message="@lang('tasks.errors.required')"
                                               placeholder="@lang('tasks.name')"
                                               value="{{  old('name',$item->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div id="status-container" class="form-group">
                                        <label for="status_id">@lang('tasks.status_id')</label>
                                        <select id="status_id" name="status_id"
                                                data-searching="@lang('tasks.search.searching')"
                                                data-no-results="@lang('tasks.search.noResults')"
                                                data-start="@lang('tasks.search.start')"
                                                class="form-control  @error('status_id') is-invalid @enderror"
                                                data-parsley-errors-container="#status-container"
                                                data-parsley-required-message="@lang('tasks.errors.required')"
                                                required
                                                data-toggle="select2">
                                            @foreach($statuses as $value)
                                                <option
                                                        @if((int)old('status_id',$item->status_id) === $value->id) selected="selected"
                                                        @endif value="{{$value->id}}">{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('status_id')
                                        <div class="invalid-feedback" style="display:block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="date_start">@lang('tasks.date_start')</label>
                                        <input type="datetime-local" id="date_start" name="date_start"
                                               class="form-control @error('date_start') is-invalid @enderror"
                                               required
                                               data-parsley-required-message="@lang('tasks.errors.required')"
                                               value="{{  old('date_start',$item->dateStart()) }}">
                                        @error('date_start')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror

                                    </div>

                                    <div class="form-group">
                                        <label for="date_end">@lang('tasks.date_end')</label>
                                        <input type="datetime-local" id="date_end" name="date_end"
                                               class="form-control @error('date_end') is-invalid @enderror"
                                               required
                                               data-parsley-required-message="@lang('tasks.errors.required')"
                                               value="{{  old('date_end',$item->dateEnd()) }}">
                                        @error('date_end')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror

                                    </div>
                                </div>
                                <!-- end col-->

                                <div class="col-xl-8">
                                    <div class="row">
                                        <div class="col-xl-6">

                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div id="source-container" class="form-group">
                                                        <label for="source">@lang('tasks.source')</label>
                                                        <select id="source" name="source"
                                                                data-searching="@lang('tasks.search.searching')"
                                                                data-no-results="@lang('tasks.search.noResults')"
                                                                data-start="@lang('tasks.search.start')"
                                                                class="form-control  @error('source') is-invalid @enderror"
                                                                data-parsley-errors-container="#source-container"
                                                                data-parsley-required-message="@lang('tasks.errors.required')"
                                                                required
                                                                data-toggle="select2">
                                                            @if(!old('source',$item->source))
                                                                <option value="">@lang('tasks.search.searching')</option>
                                                            @endif
                                                            @foreach($modelTypeList as $key=>$value)
                                                                <option
                                                                        @if((string)old('source',$item->source) === $key) selected="selected"
                                                                        @endif value="{{$key}}">{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('source')
                                                        <div class="invalid-feedback" style="display:block;">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div id="source_id-container" class="form-group">
                                                        <label for="source_id">@lang('tasks.source')</label>
                                                        <select id="source_id" name="source_id"
                                                                data-searching="@lang('tasks.search.searching')"
                                                                data-no-results="@lang('tasks.search.noResults')"
                                                                data-start="@lang('tasks.search.start')"
                                                                data-placeholder="@lang('tasks.search.chooseSourceFirst')"
                                                                data-url="{{route('request.getSource')}}"
                                                                class="form-control  @error('source') is-invalid @enderror"
                                                                data-parsley-errors-container="#source_id-container"
                                                                data-parsley-required-message="@lang('tasks.errors.required')"
                                                                required
                                                                data-toggle="select2">
                                                            @if(!empty($sourceInfo->id))
                                                                <option selected="selected"
                                                                        value="{{$sourceInfo->id}}">{{ $sourceInfo->fullname() ??$sourceInfo->name ?? $sourceInfo->title ?? 'Неизвестно'}}</option>
                                                            @endif
                                                        </select>
                                                        @error('source_id')
                                                        <div class="invalid-feedback" style="display:block;">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="priority-container" class="form-group">
                                                <label for="priority_id">@lang('tasks.priority_id')</label>
                                                <select id="priority_id" name="priority_id"
                                                        data-searching="@lang('tasks.search.searching')"
                                                        data-no-results="@lang('tasks.search.noResults')"
                                                        data-start="@lang('tasks.search.start')"
                                                        class="form-control  @error('priority_id') is-invalid @enderror"
                                                        data-parsley-errors-container="#priority-container"
                                                        data-parsley-required-message="@lang('tasks.errors.required')"
                                                        required
                                                        data-toggle="select2">
                                                    @foreach($priorities as $value)
                                                        <option
                                                                @if((int)old('priority_id',$item->priority_id) === $value->id) selected="selected"
                                                                @endif value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('priority_id')
                                                <div class="invalid-feedback" style="display:block;">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label
                                                        for="assigned_user_id">@lang('tasks.assigned_user')</label>
                                                <div id="assigned_user_container">
                                                    <select id="assigned_user_id" name="assigned_user"
                                                            class="form-control  @error('assigned_user') is-invalid @enderror"

                                                            data-info="{{route('request.getUsers')}}"
                                                            data-searching="@lang('users.search.searching')"
                                                            data-no-results="@lang('users.search.noResults')"
                                                            data-start="@lang('users.search.start')"
                                                            data-placeholder="@lang('users.search.startSearchingAssigned')"
                                                            data-url="{{route('request.getUsers')}}"
                                                            data-parsley-required-message="@lang('tasks.errors.required')"
                                                            required
                                                            data-parsley-errors-container="#assigned_user_container"
                                                            data-toggle="select2">
                                                        @if(!empty($assignedUserInfo->id))
                                                            <option selected="selected"
                                                                    value="{{$assignedUserInfo->id}}">{{$assignedUserInfo->fullname()}}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                @error('assigned_user')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">@lang('tasks.description')</label>
                                        <textarea id="description" name="description" rows="5"
                                                  class="form-control">{{  old('description',$item->description) }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <input type="hidden" name="files" value="{{$item->listFiles}}" id="listFiles">
                        </form> <!-- end card-body -->
                        @if(!empty($item->files))
                            @foreach($item->files as $file)
                                <input type="file" data-obj-id="{{$item->id}}" data-dropify-id="{{$file->id}}"
                                       class="dropify"
                                       data-show-remove="true" data-default-file="/images/{{$file->file}}"/>
                            @endforeach
                        @endif
                        <form action="{{route('tasks.upload')}}" method="post" class="dropzone"
                              id="myAwesomeDropzone">
                            @csrf
                            <div class="fallback">
                                <input name="file" type="file"/>
                            </div>

                            <div class="dz-message needsclick">
                                <i class="h1 text-muted dripicons-cloud-upload"></i>
                            </div>
                        </form>
                        <!-- end row -->
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                @if(!empty($item->id))
                                    <button type="button" id="buttonSubmit"
                                            class="btn btn-success waves-effect waves-light m-1"><i
                                                class="fe-check-circle mr-1"></i> @lang('tasks.edit')
                                    </button>
                                @else
                                    <button type="button" id="buttonSubmit"
                                            class="btn btn-success waves-effect waves-light m-1"><i
                                                class="fe-check-circle mr-1"></i> @lang('tasks.create')
                                    </button>
                                @endif
                                <button type="button" onclick="location='{{route('tasks.index')}}'"
                                        class="btn btn-light waves-effect waves-light m-1"><i
                                            class="fe-x mr-1"></i> Cancel
                                </button>
                            </div>
                        </div>

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

            <script src="{{ URL::asset('assets/libs/dropify/dropify.min.js')}}"></script>
            <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/pages/tasks.init.js')}}"></script>
@endsection
