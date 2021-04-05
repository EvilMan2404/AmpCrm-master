<div class="table-responsive">
    <table class="table table-centered mb-0">
        <thead class="thead-light">
        <tr>
            <th style="width: 20px;">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">&nbsp;</label>
                </div>
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'id' && app('request')->get('order') === 'desc') ? ['sort_by' => 'id','order' => 'asc'] : ['sort_by' => 'id','order' => 'desc']) }} ">@lang('users.id')</a>
                @if(app('request')->get('sort_by') === 'id')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th><a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'fullname' && app('request')->get('order') === 'desc') ? ['sort_by' => 'fullname','order' => 'asc'] : ['sort_by' => 'fullname','order' => 'desc']) }} ">@lang('users.fullname')</a>
                @if(app('request')->get('sort_by') === 'fullname')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif</th>
            <th>@lang('users.phone')</th>
            <th><a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'email' && app('request')->get('order') === 'desc') ? ['sort_by' => 'email','order' => 'asc'] : ['sort_by' => 'email','order' => 'desc']) }} ">@lang('users.email')</a>
                @if(app('request')->get('sort_by') === 'email')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif</th>
            <th>@lang('users.location')</th>
            <th>@lang('users.assigned_user')</th>
            <th>@lang('users.team_id')</th>
            <th>@lang('users.card_number')</th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'balance' && app('request')->get('order') === 'desc') ? ['sort_by' => 'balance','order' => 'asc'] : ['sort_by' => 'balance','order' => 'desc']) }} ">@lang('users.balance')</a>
                @if(app('request')->get('sort_by') === 'balance')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th style="width: 125px;">@lang('catalog.action')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck{{$item->id}}">
                        <label class="custom-control-label" for="customCheck{{$item->id}}">&nbsp;</label>
                    </div>
                </td>
                <td><a href="javascript: void(0);" class="text-body font-weight-bold">#{{$item->id}}</a></td>
                <td>
                    {{$item->fullname()}}
                </td>
                <td>
                    {{$item->phone ?? __('users.empty')}}
                </td>
                <td>
                    {{$item->email}}
                </td>
                <td>
                    {{ ($item->countryRelation) ? $item->countryRelation->title : __('users.empty')}}
                    /
                    {{ ($item->cityRelation) ? $item->cityRelation->title : __('users.empty')}}
                    /
                    {{ $item->street ?? __('users.empty')}}
                    /
                    {{ $item->address ?? __('users.empty')}}
                </td>
                <td>
                    {{ ($item->assignedUser) ? $item->assignedUser->fullName() : __('users.empty')}}
                </td>
                <td>
                    {{ ($item->teamIdRelation) ? $item->teamIdRelation->name : __('users.empty')}}
                </td>
                <td>
                    {{ $item->card_number ?? __('users.empty')}}
                </td>
                <td>
                    {{ $item->balance ?? 0.00 }}
                </td>
                <td>
                    <a href="{{route('users.info',$item->id)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                    @can('policy','guard_users_edit|guard_users_edit_self,'.$item->assigned_user)
                        <a href="{{route('users.edit',$item->id)}}" class="action-icon"> <i
                                    class="mdi mdi-square-edit-outline"></i></a>
                    @endcan
                    @if($item->id !== Auth::id())
                        @can('policy','guard_users_delete|guard_users_delete_self,'.$item->assigned_user)
                            <a href="{{route('users.delete',$item->id)}}"
                               onclick="return confirm('{{__('index.confirmation')}}');" class="action-icon"> <i
                                        class="mdi mdi-delete"></i></a>
                        @endcan
                    @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
