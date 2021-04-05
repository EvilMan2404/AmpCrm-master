<div class="table-responsive">
    <table class="table table-centered mb-0">
        <thead class="thead-light">
        <tr>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'id' && app('request')->get('order') === 'desc') ? ['sort_by' => 'id','order' => 'asc'] : ['sort_by' => 'id','order' => 'desc']) }} ">@lang('space.id')</a>
                @if(app('request')->get('sort_by') === 'id')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'title' && app('request')->get('order') === 'desc') ? ['sort_by' => 'title','order' => 'asc'] : ['sort_by' => 'title','order' => 'desc']) }} ">@lang('space.name')</a>
                @if(app('request')->get('sort_by') === 'title')
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
                    {{$item->title}}
                </td>
                <td>
                    <a href="{{route('space.index',['edit' => $item->id])}}" class="action-icon"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                    <a href="{{route('space.delete',$item->id)}}"
                       onclick="return confirm('{{__('index.confirmation')}}');" class="action-icon"> <i
                                class="mdi mdi-delete"></i></a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>



