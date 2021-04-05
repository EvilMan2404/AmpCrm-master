@extends('layouts.master')
@section('css')
@endsection
@section('content')
    <div class="container-fluid">

        @include('components.breadcrumb',$breadcrumb)
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="mt-0 mb-1">{{$item->fullname()}}</h4>
                            <p class="text-muted"><i
                                        class="mdi mdi-office-building"></i> {{ ($item->spaceRelation) ? $item->spaceRelation->title : __('client.empty') }}
                            </p>

                            <a href="tel://{{$item->phone}}" class="btn- btn-xs btn-info">@lang('users.call')</a>
                            <a href="{{route('users.edit',$item->id)}}"
                               class="btn- btn-xs btn-secondary">@lang('users.edit_button')</a>
                            <a href="{{route('users.delete',$item->id)}}"
                               onclick="return confirm('{{__('index.confirmation')}}');"
                               class="btn- btn-xs btn-danger">@lang('users.delete')</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-box pt-1">
                    <h5 class="mb-3 text-uppercase bg-info p-2"><i class="mdi mdi-account-circle mr-1"></i>
                        @lang('client.commonInformation')</h5>
                    <div class="">
                        <h4 class="font-13 text-muted text-uppercase"> @lang('users.email') :</h4>
                        <p class="mb-3">
                            {{$item->email ?? __('users.empty')}}
                        </p>

                        <h4 class="font-13 text-muted text-uppercase"> @lang('users.phone') :</h4>
                        <p class="mb-3">
                            {{$item->phone ?? __('users.empty')}}
                        </p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('users.team_id')</h4>
                        <p class="mb-3"> {{ ($item->teamIdRelation) ? $item->teamIdRelation->name : __('users.empty')}}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('users.assigned_user') :</h4>
                        <p class="mb-3">{{ ($item->assignedUser) ? $item->assignedUser->fullName() : __('users.empty')}}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('users.space_id') :</h4>
                        <p class="mb-3">{{ ($item->spaceRelation) ? $item->spaceRelation->title : __('users.empty')}}</p>


                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.created_at') :</h4>
                        <p class="mb-3"> {{$item->created_at->format('Y-m-d H:i')}}</p>

                        <h4 class="font-13 text-muted text-uppercase mb-1">@lang('client.updated_at') :</h4>
                        <p class="mb-0"> {{$item->updated_at->format('Y-m-d H:i')}}</p>

                    </div>

                </div> <!-- end card-box-->
            </div>
            <div class="col-lg-2">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box pt-1">
                            <h5 class="mb-3 text-uppercase bg-info p-2"><i class="mdi mdi-account-circle mr-1"></i>
                                @lang('users.location')</h5>
                            <div class="">
                                <h4 class="font-13 text-muted text-uppercase mb-1">@lang('users.country_id')</h4>
                                <p class="mb-3"> {{ ($item->countryRelation) ? $item->countryRelation->title : __('users.empty')}}</p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">@lang('users.city_id')</h4>
                                <p class="mb-3"> {{ ($item->cityRelation) ? $item->cityRelation->title : __('users.empty')}} </p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">@lang('users.street')</h4>
                                <p class="mb-3"> {{ $item->street ?? __('users.empty')}}</p>

                                <h4 class="font-13 text-muted text-uppercase mb-1">@lang('users.address')</h4>
                                <p class=""> {{ $item->address ?? __('users.empty')}}</p>
                            </div>

                        </div> <!-- end card-box--></div>
                    <div class="col-lg-12">
                        <div class="card-box pt-1">

                            <div class="">
                                <h4 class="font-13 text-muted text-uppercase"> @lang('users.card_number') :</h4>
                                <p class="mb-3">
                                    {{$item->card_number ?? __('users.empty')}}
                                </p>

                                <h4 class="font-13 text-muted text-uppercase"> @lang('users.balance') :</h4>
                                <p class="">
                                    {{$item->balance ?? __('users.empty')}} €
                                </p>
                            </div>

                        </div> <!-- end card-box--></div>
                </div>

            </div>
            <div class="col-lg-4">
                <div class="card-box pt-1">
                    <h5 class="mb-3 text-uppercase bg-info p-2"><i class="mdi mdi-account-circle mr-1"></i>
                        @lang('users.tasks')</h5>
                    <div class="">
                        @forelse($item->tasks as $task)
                            <li class="list-group-item"><a style="color: #ffffff"
                                        href="{{route('tasks.info',$task->id)}}">{{$task->name}}</a></li>
                        @empty
                            @lang('users.no_tasks')
                        @endforelse
                    </div>

                </div> <!-- end card-box-->
            </div>
        </div>
    </div>
@endsection
