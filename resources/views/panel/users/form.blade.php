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
                <div class="card">
                    <div class="card-body">
                        <form class="clientForm" method="post" enctype="multipart/form-data"
                              action="{{route('users.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                            @csrf
                            <div class="row">
                                <div class="col-xl-4">

                                    <div class="form-group">
                                        <label for="name">@lang('users.name')</label>
                                        <input type="text" id="name" name="name"
                                               class="form-control @error('name') is-invalid @enderror" required
                                               data-parsley-required-message="@lang('users.errors.name')"
                                               placeholder="@lang('users.name')"
                                               value="{{  old('name',$item->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="third_name">@lang('users.third_name')</label>
                                        <input name="third_name"
                                               class="form-control @error('third_name') is-invalid @enderror"
                                               data-parsley-required-message="@lang('users.errors.third_name')"
                                               required
                                               placeholder="@lang('users.third_name')"
                                               value="{{old('third_name',$item->third_name)}}">
                                        @error('third_name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="second_name">@lang('users.second_name')</label>
                                        <div>
                                            <input id="second_name" name="second_name" type="text"
                                                   class="form-control @error('second_name') is-invalid @enderror"
                                                   placeholder="@lang('users.second_name')"
                                                   data-parsley-required-message="@lang('users.errors.second_name')"
                                                   required
                                                   value="{{  old('second_name',$item->second_name) }}">
                                        </div>
                                        @error('second_name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">@lang('users.phone')</label>
                                        <div>
                                            <input id="phone" name="phone" type="tel"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   data-parsley-required-message="@lang('users.errors.phone')"
                                                   required placeholder="@lang('users.phone')"
                                                   value="{{ old('phone',$item->phone) }}"/>
                                        </div>
                                        @error('phone')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">@lang('users.email')</label>
                                        <div>
                                            <input id="email" name="email" type="email"
                                                   parsley-type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   data-parsley-error-message="@lang('users.errors.email')"
                                                   required placeholder="@lang('users.email')"
                                                   value="{{ old('email',$item->email) }}"/>
                                        </div>
                                        @error('email')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- end col-->
                                <div class="col-xl-4">

                                    <div id="address_country" class="form-group">
                                        <label for="country">@lang('users.country_id')</label>
                                        <select id="country" name="country_id"
                                                data-searching="@lang('users.search.searching')"
                                                data-no-results="@lang('users.search.noResults')"
                                                data-start="@lang('users.search.start')"
                                                data-placeholder="@lang('users.form.choose_country')"
                                                class="form-control  @error('country_id') is-invalid @enderror"
                                                data-parsley-errors-container="#address_country"
                                                data-parsley-required-message="@lang('users.errors.country_id')"
                                                required
                                                data-toggle="select2">
                                            @if(!old('country_id',$item->country_id))
                                                <option disabled selected>@lang('users.form.choose_country')</option>
                                            @endif
                                            @foreach($country as $value)
                                                <option
                                                        @if((int)old('country_id',$item->country_id) === $value->id) selected="selected"
                                                        @endif value="{{$value->id}}">{{$value->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                        <div class="invalid-feedback" style="display:block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="city">@lang('users.city_id')</label>
                                        <div id="address_city-block">
                                            <select id="city" name="city_id"
                                                    class="@error('city_id') is-invalid @enderror form-control"

                                                    data-searching="@lang('users.search.searching')"
                                                    data-no-results="@lang('users.search.noResults')"
                                                    data-start="@lang('users.search.start')"
                                                    data-placeholder="@lang('users.form.choose_country_first')"
                                                    data-url="{{route('request.getCities')}}"
                                                    data-parsley-errors-container="#address_city-block"
                                                    data-parsley-required-message="@lang('users.errors.city_id')"
                                                    required
                                                    data-toggle="select2">

                                                @if(!empty($cityInfo->id))
                                                    <option selected="selected"
                                                            value="{{$cityInfo->id}}">{{$cityInfo->title}}</option>
                                                @endif
                                            </select>
                                        </div>
                                        @error('city_id')
                                        <div class="invalid-feedback" style="display:block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label
                                                for="street">@lang('users.street')</label>
                                        <div>
                                            <input id="street" name="street" type="text"
                                                   class="form-control @error('street') is-invalid @enderror"
                                                   required placeholder="@lang('users.street')"
                                                   data-parsley-required-message="@lang('users.errors.street')"
                                                   value="{{old('street',$item->street)}}"/>
                                        </div>
                                        @error('street')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label
                                                for="address">@lang('users.address')</label>
                                        <div>
                                            <input id="address" name="address" type="text"
                                                   class="form-control @error('address') is-invalid @enderror"
                                                   required placeholder="@lang('users.address')"
                                                   data-parsley-required-message="@lang('users.errors.address')"
                                                   value="{{old('address',$item->address)}}"/>
                                        </div>
                                        @error('address')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">

                                            <div class="form-group">
                                                <label
                                                        for="password">@lang('users.password')</label>
                                                <div>
                                                    <input id="password" name="password" type="password"
                                                           class="form-control @error('password') is-invalid @enderror"
                                                           @if(Route::is('users.create'))
                                                           required
                                                           @endif
                                                           placeholder="@lang('users.password')"
                                                           data-parsley-required-message="@lang('users.errors.password')"
                                                           value=""/>
                                                </div>
                                                @error('password')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-6">

                                            <div class="form-group">
                                                <label
                                                        for="password">@lang('users.r_password')</label>
                                                <div>
                                                    <input id="password" name="password_confirmation" type="password"
                                                           class="form-control @error('password') is-invalid @enderror"
                                                           @if(Route::is('users.create'))
                                                           required
                                                           @endif
                                                           data-parsley-equalto="#password"
                                                           placeholder="@lang('users.r_password')"
                                                           data-parsley-error-message="@lang('users.errors.r_password')"
                                                           value=""/>
                                                </div>
                                                @error('password_confirmation')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label
                                                for="assigned_user_id">@lang('users.assigned_user')</label>
                                        <div id="assigned_user_container">
                                            <select id="assigned_user_id" name="assigned_user"
                                                    class="form-control  @error('assigned_user') is-invalid @enderror"

                                                    data-info="{{route('request.getUsers')}}"
                                                    data-searching="@lang('users.search.searching')"
                                                    data-no-results="@lang('users.search.noResults')"
                                                    data-start="@lang('users.search.start')"
                                                    data-placeholder="@lang('users.search.startSearchingAssigned')"
                                                    data-url="{{route('request.getUsers')}}"

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
                                    @if(!empty($item->id))
                                        @can('policy','guard_users_teams')
                                            <div class="form-group">
                                                <label
                                                        for="team_id">@lang('users.team_id')</label>
                                                <div id="team_id_container">
                                                    <select id="team_id" name="team_id"
                                                            class="form-control  @error('team_id') is-invalid @enderror"

                                                            data-info="{{route('request.getTeams')}}"
                                                            data-searching="@lang('users.search.searching')"
                                                            data-no-results="@lang('users.search.noResults')"
                                                            data-start="@lang('users.search.start')"
                                                            data-placeholder="@lang('users.search.startSearching')"
                                                            data-url="{{route('request.getTeams')}}"

                                                            required
                                                            data-parsley-error-message="@lang('users.errors.team_id')"
                                                            data-parsley-errors-container="#team_id_container"
                                                            data-toggle="select2">
                                                        @if(!empty($teamInfo->id))
                                                            <option selected="selected"
                                                                    value="{{$teamInfo->id}}">{{$teamInfo->name}}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                @error('team_id')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        @endcan
                                    @else
                                        <div class="form-group">
                                            <label
                                                    for="team_id">@lang('users.team_id')</label>
                                            <div id="team_id_container">
                                                <select id="team_id" name="team_id"
                                                        class="form-control  @error('team_id') is-invalid @enderror"

                                                        data-info="{{route('request.getTeams')}}"
                                                        data-searching="@lang('users.search.searching')"
                                                        data-no-results="@lang('users.search.noResults')"
                                                        data-start="@lang('users.search.start')"
                                                        data-placeholder="@lang('users.search.startSearching')"
                                                        data-url="{{route('request.getTeams')}}"

                                                        required
                                                        data-parsley-error-message="@lang('users.errors.team_id')"
                                                        data-parsley-errors-container="#team_id_container"
                                                        data-toggle="select2">
                                                    @if(!empty($teamInfo->id))
                                                        <option selected="selected"
                                                                value="{{$teamInfo->id}}">{{$teamInfo->name}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                            @error('team_id')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label
                                                for="card_number">@lang('users.card_number')</label>
                                        <div>
                                            <input id="card_number" name="card_number" type="text"
                                                   data-parsley-type="number"
                                                   class="form-control @error('card_number') is-invalid @enderror"
                                                   required placeholder="@lang('users.card_number')"
                                                   data-parsley-error-message="@lang('users.errors.card_number')"
                                                   value="{{old('card_number',$item->card_number)}}"/>
                                        </div>
                                        @error('card_number')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>


                                <!--                                    <div class="form-group">
                                        <label
                                                for="space_id">@lang('users.space_id')</label>
                                        <div id="space_id_container">
                                            <select id="space_id" name="space_id"
                                                    class="form-control  @error('space_id') is-invalid @enderror"

                                                    data-info="{{route('request.getSpaces')}}"
                                                    data-searching="@lang('users.search.searching')"
                                                    data-no-results="@lang('users.search.noResults')"
                                                    data-start="@lang('users.search.start')"
                                                    data-placeholder="@lang('users.search.startSearching')"
                                                    data-url="{{route('request.getSpaces')}}"
                                                    @if(Route::is('users.create'))
                                    required
@endif
                                        data-parsley-error-message="@lang('users.errors.space_id')"
                                                    data-parsley-errors-container="#space_id_container"
                                                    data-toggle="select2">
                                                @if(!empty($spaceInfo->id))
                                    <option selected="selected"
                                            value="{{$spaceInfo->id}}">{{$spaceInfo->title}}</option>
                                                @endif
                                        </select>
                                    </div>
@error('space_id')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                        </div>-->
                                    @if(!empty($item->id))
                                        @can('policy','guard_users_roles')
                                            <div id="roleId-container" class="form-group">
                                                <label for="roleId">@lang('users.role_id')</label>
                                                <select id="roleId" name="role_id"
                                                        data-searching="@lang('users.search.searching')"
                                                        data-no-results="@lang('users.search.noResults')"
                                                        data-start="@lang('users.search.start')"
                                                        data-placeholder="@lang('users.form.role_id')"
                                                        class="form-control  @error('role_id') is-invalid @enderror"
                                                        data-parsley-errors-container="#roleId-container"
                                                        data-parsley-required-message="@lang('users.errors.role_id')"
                                                        required
                                                        data-toggle="select2">
                                                    @foreach($roles as $value)
                                                        <option @if(!empty($value->roleIdRelation) && $chosenRole === $value->roleIdRelation->id) selected
                                                                @endif value="{{$value->roleIdRelation->id}}">{{$value->roleIdRelation->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('role_id')
                                                <div class="invalid-feedback" style="display:block;">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        @endcan
                                    @else
                                        <div id="roleId-container" class="form-group">
                                            <label for="roleId">@lang('users.role_id')</label>
                                            <select id="roleId" name="role_id"
                                                    data-searching="@lang('users.search.searching')"
                                                    data-no-results="@lang('users.search.noResults')"
                                                    data-start="@lang('users.search.start')"
                                                    data-placeholder="@lang('users.form.role_id')"
                                                    class="form-control  @error('role_id') is-invalid @enderror"
                                                    data-parsley-errors-container="#roleId-container"
                                                    data-parsley-required-message="@lang('users.errors.role_id')"
                                                    required
                                                    data-toggle="select2">
                                                @foreach($roles as $value)
                                                    <option @if($chosenRole === $value->roleIdRelation->id) selected
                                                            @endif value="{{$value->roleIdRelation->id}}">{{$value->roleIdRelation->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
                                            <div class="invalid-feedback" style="display:block;">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>

                                    @endif


                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    @if(!empty($item->id))
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                    class="fe-check-circle mr-1"></i> @lang('users.edit')
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                    class="fe-check-circle mr-1"></i> @lang('users.create')
                                        </button>
                                    @endif
                                    <button type="button" onclick="location='{{route('users.index')}}'"
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
            <!-- Plugin js-->
            <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
            <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
            <script src="{{ URL::asset('assets/js/pages/users.init.js')}}"></script>
@endsection
