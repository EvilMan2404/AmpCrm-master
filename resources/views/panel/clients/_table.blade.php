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
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'id' && app('request')->get('order') === 'desc') ? ['sort_by' => 'id','order' => 'asc'] : ['sort_by' => 'id','order' => 'desc']) }} ">@lang('client.id')</a>
                @if(app('request')->get('sort_by') === 'id')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>@lang('client.photo')</th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'fullname' && app('request')->get('order') === 'desc') ? ['sort_by' => 'fullname','order' => 'asc'] : ['sort_by' => 'fullname','order' => 'desc']) }} ">@lang('client.fullname')</a>
                @if(app('request')->get('sort_by') === 'fullname')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>@lang('client.phone')</th>
            <th>@lang('client.c_type')</th>
            <th>@lang('client.industry')</th>
            <th>@lang('client.billing')</th>
            <th>@lang('client.shipping')</th>
            <th>@lang('client.assigned_user_id')</th>
            <th>@lang('client.group_id')</th>
            <th>@lang('client.updated_at')</th>
            <th>@lang('client.created_at')</th>
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
                    @if(!empty($item->files))
                        <a href="/images/{{$item->files->file}}" data-fancybox
                           data-caption="{{$item->files->name}}"><img src="images/{{$item->files->file}}"
                                                                      alt="{{$item->files->name}}"
                                                                      height="32"/></a>@endif

                </td>
                <td>
                    {{$item->fullname()}}
                </td>
                <td>
                    {{$item->phone}}
                </td>
                <td>
                    {{ ($item->clientTypeRelation) ? $item->clientTypeRelation->title : __('client.empty')}}
                </td>
                <td>
                    {{ ($item->clientIndustry) ? $item->clientIndustry->title : __('client.empty') }}
                </td>
                <td>
                    {{ ($item->countriesBillingRelation) ? $item->countriesBillingRelation->title : __('client.empty')}}
                    /
                    {{ $item->billing_address_state ?? __('client.empty')}}
                    / {{ ($item->citiesBilling) ? $item->citiesBilling->title : __('client.empty')}} /
                    {{ $item->billing_address_street ?? __('client.empty')}}
                </td>
                <td>
                    {{ ($item->countriesShippingRelation) ? $item->countriesShippingRelation->title : __('client.empty')}}
                    /
                    {{ $item->shipping_address_state ?? __('client.empty')}}
                    / {{ ($item->citiesShipping) ? $item->citiesShipping->title : __('client.empty')}} /
                    {{ $item->shipping_address_street ?? __('client.empty')}}
                </td>
                <td>
                    {{ ($item->assignedUser) ? $item->assignedUser->fullName() : __('client.empty')}}
                </td>
                <td>
                    {{ ($item->clientGroupTypeRelation) ? $item->clientGroupTypeRelation->title : __('client.empty')}}
                </td>
                <td>
                    {{$item->created_at->format('Y-m-d H:i')}}
                </td>
                <td>
                    {{$item->updated_at->format('Y-m-d H:i')}}
                </td>
                <td>
                    <a href="{{route('client.info',$item->id)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                    @can('policy','guard_clients_edit|guard_clients_edit_self,'.$item->assigned_user_id)
                        <a href="{{route('client.edit',$item->id)}}" class="action-icon"> <i
                                    class="mdi mdi-square-edit-outline"></i></a>
                    @endcan
                    @can('policy','guard_clients_delete|guard_clients_delete_self,'.$item->assigned_user_id)
                        <a href="{{route('client.delete',$item->id)}}"
                           onclick="return confirm('{{__('index.confirmation')}}');" class="action-icon"> <i
                                    class="mdi mdi-delete"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
