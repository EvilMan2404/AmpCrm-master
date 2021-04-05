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
                   href="{{ request()->fullUrlWithQuery((app('request')->get('sort_by') === 'id' && app('request')->get('order') === 'desc') ? ['sort_by' => 'id','order' => 'asc'] : ['sort_by' => 'id','order' => 'desc']) }} ">@lang('tasks.id')</a>
                @if(app('request')->get('sort_by') === 'id')
                    @if(app('request')->get('order') === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>@lang('tasks.name')</th>
            <th>@lang('tasks.status_id')</th>
            <th>@lang('tasks.priority_id')</th>
            <th>@lang('tasks.date_start')</th>
            <th>@lang('tasks.date_end')</th>
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
                <td>{{$item->name}}</td>
                <td>{{$item->statusRelation->name}}</td>
                <td>{{$item->priorityRelation->name}}</td>
                <td>{{$item->date_start}}</td>
                <td>{{$item->date_end}}</td>
                <td>
                    <a href="{{route('tasks.info',$item->id)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>

                    @can('policy','guard_tasks_edit|guard_tasks_edit_self,'.$item->user_id)
                        <a href="{{route('tasks.edit',$item->id)}}" class="action-icon"> <i
                                    class="mdi mdi-square-edit-outline"></i></a>
                    @endcan

                    @can('policy','guard_tasks_delete|guard_tasks_delete_self,'.$item->user_id)
                        <a href="{{route('tasks.delete',$item->id)}}"
                           onclick="return confirm('{{__('index.confirmation')}}');" class="action-icon"> <i
                                    class="mdi mdi-delete"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
