<div class="table-responsive">
    <table class="table table-centered mb-0">
        <thead class="thead-light">
        <tr>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'id' && app('request')->get('order') === 'desc') ? ['sort_by' => 'id','order' => 'asc'] : ['sort_by' => 'id','order' => 'desc']) }} ">@lang('taskPriority.id')</a>
                @if(app('request')->get('sort_by') === 'id')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'name' && app('request')->get('order') === 'desc') ? ['sort_by' => 'name','order' => 'asc'] : ['sort_by' => 'name','order' => 'desc']) }} ">@lang('taskPriority.name')</a>
                @if(app('request')->get('sort_by') === 'name')
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
                    <span class="p-1 rounded" style="background-color: {{$item->background_color}};color:{{$item->text_color}}">
                        {{$item->name}}
                    </span>
                </td>
                <td>
                    @can('policy','guard_task_priorities_edit')
                    <a href="{{route('taskPriority.index',['edit' => $item->id,$path])}}" class="action-icon"> <i
                                class="mdi mdi-square-edit-outline"></i></a>
                    <a href="{{route('taskPriority.delete',$item->id)}}"
                       onclick="return confirm('{{__('index.confirmation')}}');" class="action-icon"> <i
                                class="mdi mdi-delete"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>



