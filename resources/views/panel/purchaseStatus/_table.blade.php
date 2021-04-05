<div class="table-responsive">
    <table class="table table-centered mb-0">
        <thead class="thead-light">
        <tr>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'id' && app('request')->get('order') === 'desc') ? ['sort_by' => 'id','order' => 'asc'] : ['sort_by' => 'id','order' => 'desc']) }} ">@lang('purchaseStatus.id')</a>
                @if(app('request')->get('sort_by') === 'id')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'name' && app('request')->get('order') === 'desc') ? ['sort_by' => 'name','order' => 'asc'] : ['sort_by' => 'name','order' => 'desc']) }} ">@lang('purchaseStatus.name')</a>
                @if(app('request')->get('sort_by') === 'name')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                @lang('purchaseStatus.final')
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
                    @if($item->final)
                        @lang('index.additional.yes')
                    @else
                        @lang('index.additional.no')
                    @endif

                </td>
                <td>
                    @can('policy','guard_purchase_statuses_edit')
                        <a href="{{route('purchaseStatus.index',['edit' => $item->id,$path])}}" class="action-icon"> <i
                                    class="mdi mdi-square-edit-outline"></i></a>
                        <a href="{{route('purchaseStatus.delete',$item->id)}}"
                           onclick="return confirm('{{__('index.confirmation')}}');" class="action-icon"> <i
                                    class="mdi mdi-delete"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>



