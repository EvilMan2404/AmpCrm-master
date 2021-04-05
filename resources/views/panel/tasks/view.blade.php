@extends('layouts.master')
@section('css')
@endsection
@section('content')
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <!-- project card -->
                <div class="card d-block">
                    <div class="card-body">
                        <h4>{{$item->name}}</h4>

                        <div class="row">
                            <div class="col-md-4">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">@lang('tasks.assigned_user')</p>
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->assignedRelation->fullname()}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div> <!-- end col -->

                            <div class="col-md-4">
                                <!-- start due date -->
                                <p class="mt-2 mb-1 text-muted">@lang('tasks.source')</p>
                                <div class="media">
                                    <i class="mdi mdi-briefcase-check-outline font-18 text-success mr-1"></i>
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$source}}
                                            , {{$sourceInfo->fullname()??$sourceInfo->name??$sourceInfo->title}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end due date -->
                            </div>

                            <div class="col-md-2">
                                <!-- start due date -->
                                <p class="mt-2 mb-1 text-muted">@lang('tasks.date_start')</p>
                                <div class="media">
                                    <i class="mdi mdi-calendar-month-outline font-18 text-success"></i>
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->date_start}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end due date -->
                            </div> <!-- end col -->
                            <div class="col-md-2">
                                <!-- start due date -->
                                <p class="mt-2 mb-1 text-muted">@lang('tasks.date_end')</p>
                                <div class="media">
                                    <i class="mdi mdi-calendar-month-outline font-18 text-success"></i>
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->date_end}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end due date -->
                            </div> <!-- end col -->
                            <div class="col-md-4">
                                <!-- start due date -->
                                <p class="mt-2 mb-1 text-muted">@lang('tasks.status_id')</p>
                                <div class="media">
                                    <i class="mdi mdi-calendar-month-outline font-18 text-success"></i>
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->statusRelation->name}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end due date -->
                            </div> <!-- end col -->
                            <div class="col-md-4">
                                <!-- start due date -->
                                <p class="mt-2 mb-1 text-muted">@lang('tasks.priority_id')</p>
                                <div class="media">
                                    <i class="mdi mdi-calendar-month-outline font-18 text-success"></i>
                                    <div class="media-body">
                                        <h5 class="mt-1 font-size-14">
                                            {{$item->priorityRelation->name}}
                                        </h5>
                                    </div>
                                </div>
                                <!-- end due date -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->


                        <h5 class="mt-3">@lang('tasks.description'):</h5>

                        <p class="text-muted mb-4">
                            {{$item->description ?? 'Описание не введено!'}}
                        </p>


                    </div> <!-- end card-body-->

                </div> <!-- end card-->
                <!-- end card-->
            </div> <!-- end col -->

            <div class="col-xl-4 col-lg-5">

                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title font-16 mb-3">@lang('tasks.files')</h5>
                        @foreach($item->files as $file)
                            <div class="card mb-1 shadow-none border">
                                <div class="p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-sm">
                                                <span class="avatar-title badge-soft-primary text-primary rounded">
                                                    {{$file->ext}}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col pl-0">
                                            <a href="javascript:void(0);"
                                               class="text-muted font-weight-bold">{{$file->name}}</a>
                                            <p class="mb-0 font-12">{{$file->size}} KB</p>
                                        </div>
                                        <div class="col-auto">
                                            <!-- Button -->
                                            <form method="post" id="download-{{$file->id}}"
                                                  action="{{route('tasks.getFile')}}">
                                                @csrf
                                                <input type="hidden" name="filename" value="{{$file->file}}">
                                            </form>
                                            <a onclick="return $('#download-{{$file->id}}').submit();"
                                               class="btn btn-link font-16 text-muted">
                                                <i class="dripicons-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
