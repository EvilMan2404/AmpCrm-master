<div class="table-responsive">
    <table class="table table-centered mb-0">
        <thead class="thead-light">
        <tr>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['id'] }} ">@lang('permissions.id')</a>
                @if($sort_by === 'id')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['name'] }} ">@lang('permissions.name')</a>
                @if($sort_by === 'name')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['guard_name'] }} ">@lang('permissions.guard_name')</a>
                @if($sort_by === 'guard_name')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th style="width: 125px;">@lang('permissions.action')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr>
                <td><a href="javascript: void(0);" class="text-body font-weight-bold">#{{$item->id}}</a></td>
                <td>
                    <button class="btn p-0" title="{{$item->desc}}"
                            data-plugin="tippy" data-tippy-placement="top">
                        {{$item->name}}
                        <i class="fas fas fa-question-circle"></i>
                    </button>

                </td>
                <td>
                    {{$item->guard_name}}
                </td>
                <td>
                    @can('policy','guard_permissions_edit')
                        <a href="{{route('permissions.index',['edit' => $item->id,$path])}}" class="action-icon"> <i
                                    class="mdi mdi-square-edit-outline"></i></a>
                        <a href="{{route('permissions.delete',$item->id)}}"
                           onclick="return confirm('{{__('index.confirmation')}}');" class="action-icon"> <i
                                    class="mdi mdi-delete"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>



