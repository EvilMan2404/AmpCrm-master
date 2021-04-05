<div class="table-responsive">
    <table class="table table-centered mb-0">
        <thead class="thead-light">
        <tr>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{$links['id']}}">@lang('company.id')</a>
                @if($sort_by === 'id')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>@lang('company.logo')</th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{$links['name']}}">@lang('company.name')</a>
                @if($sort_by === 'name')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif</th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{$links['website']}}">@lang('company.website')</a>
                @if($sort_by === 'website')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th><a class="text-light" style="text-decoration: underline"
                   href="{{$links['email']}} ">@lang('company.email')</a>
                @if($sort_by === 'email')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif</th>
            <th>@lang('company.phone')</th>
            <th>@lang('company.address')</th>
            <th>@lang('company.payment_info')</th>
            <th>@lang('company.last_user_id')</th>
            <th><a class="text-light" style="text-decoration: underline"
                   href="{{$links['updated_at']}} ">@lang('company.updated_at')</a>
                @if($sort_by === 'updated_at')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif</th>
            <th>@lang('company.created_at')</th>
            <th style="width: 125px;">@lang('catalog.action')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr>
                <td><a href="javascript: void(0);" class="text-body font-weight-bold">#{{$item->id}}</a></td>
                <td>
                    @if(!empty($item->files))
                        <a href="images/{{$item->files->file}}" data-fancybox data-caption="{{$item->files->name}}">
                            <img src="images/{{$item->files->file}}" height="32" alt="{{$item->files->name}}"/>
                        </a>
                    @endif

                </td>
                <td>
                    {{$item->name}}
                </td>
                <td>
                    {{$item->website}}
                </td>
                <td>
                    {{$item->email}}
                </td>
                <td>
                    {{$item->phone}}
                </td>
                <td>
                    {{ ($item->countriesRelation) ? $item->countriesRelation->title : 'Unknown'}} /
                    {{ $item->billing_address_state ?? 'Unknown'}}
                    / {{ ($item->citiesRelation) ? $item->citiesRelation->title : 'Unknown'}} /
                    {{ $item->billing_address_street ?? 'Unknown'}}
                </td>
                <td>
                    {{$item->payment_info}}
                </td>
                <td>
                    {{ ($item->userEdited) ? $item->userEdited->fullName() : 'unknown'}}
                </td>
                <td>
                    {{$item->created_at->format('Y-m-d H:i')}}
                </td>
                <td>
                    {{$item->updated_at->format('Y-m-d H:i')}}
                </td>
                <td>
                    <a href="{{route('company.info',$item->id)}}" class="action-icon"> <i
                                class="mdi mdi-eye"></i></a>
                    @can('policy','guard_company_edit|guard_company_edit_self,'.$item->user_id)
                        <a href="{{route('company.edit',$item->id)}}" class="action-icon"> <i
                                    class="mdi mdi-square-edit-outline"></i></a>
                    @endcan
                    @can('policy','guard_company_delete|guard_company_delete_self,'.$item->user_id)
                        <a href="{{route('company.delete',$item->id)}}"
                           onclick="return confirm('{{__('index.confirmation')}}');" class="action-icon"> <i
                                    class="mdi mdi-delete"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
