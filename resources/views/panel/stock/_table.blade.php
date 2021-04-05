<div class="table-responsive">
    <table class="table table-centered mb-0">
        <thead class="thead-light">
        <tr>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'id' && app('request')->get('order') === 'desc') ? ['sort_by' => 'id','order' => 'asc'] : ['sort_by' => 'id','order' => 'desc']) }} ">@lang('stock.id')</a>
                @if(app('request')->get('sort_by') === 'id')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'name' && app('request')->get('order') === 'desc') ? ['sort_by' => 'name','order' => 'asc'] : ['sort_by' => 'name','order' => 'desc']) }} ">@lang('stock.name')</a>
                @if(app('request')->get('sort_by') === 'name')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'date' && app('request')->get('order') === 'desc') ? ['sort_by' => 'date','order' => 'asc'] : ['sort_by' => 'date','order' => 'desc']) }} ">@lang('stock.date')</a>
                @if(app('request')->get('sort_by') === 'date')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>@lang('stock.user_id')</th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'weight_ceramics' && app('request')->get('order') === 'desc') ? ['sort_by' => 'weight_ceramics','order' => 'asc'] : ['sort_by' => 'weight_ceramics','order' => 'desc']) }} ">@lang('stock.ceramic')</a>
                @if(app('request')->get('sort_by') === 'weight_ceramics')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'weight_dust' && app('request')->get('order') === 'desc') ? ['sort_by' => 'weight_dust','order' => 'asc'] : ['sort_by' => 'weight_dust','order' => 'desc']) }} ">@lang('stock.dust')</a>
                @if(app('request')->get('sort_by') === 'weight_dust')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'metallic' && app('request')->get('order') === 'desc') ? ['sort_by' => 'metallic','order' => 'asc'] : ['sort_by' => 'metallic','order' => 'desc']) }} ">@lang('stock.metallic')</a>
                @if(app('request')->get('sort_by') === 'metallic')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'catalyst' && app('request')->get('order') === 'desc') ? ['sort_by' => 'catalyst','order' => 'asc'] : ['sort_by' => 'catalyst','order' => 'desc']) }} ">@lang('stock.catalyst')</a>
                @if(app('request')->get('sort_by') === 'catalyst')
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
                <td><a href="javascript: void(0);" class="text-body font-weight-bold">#{{$item->id}}</a></td>
                <td>
                    {{$item->name}}
                </td>
                <td>
                    {{\Carbon\Carbon::parse($item->date)->format('d.m.Y')}}
                </td>
                <td>   {!! $item->getOwner() !!}
                </td>
                <td>
                    {{$item->weight_ceramics}}
                </td>
                <td>
                    {{$item->weight_dust}}
                </td>
                <td>
                    {{$item->metallic}}
                </td>
                <td>
                    {{$item->catalyst}}
                </td>
                <td>
                    <a href="{{route('stock.info',$item->id)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                    @can('policy','guard_stock_edit|guard_stock_edit_self,'.$item->user_id)
                        <a href="{{route('stock.edit',$item->id)}}" class="action-icon"> <i
                                    class="mdi mdi-square-edit-outline"></i></a>
                    @endcan
                    @can('policy','guard_stock_delete|guard_stock_delete_self,'.$item->user_id)
                        <a href="{{route('stock.delete',$item->id)}}"
                           onclick="return confirm('{{__('index.confirmation')}}');" class="action-icon"> <i
                                    class="mdi mdi-delete"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
