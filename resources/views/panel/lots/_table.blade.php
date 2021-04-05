<div class="table-responsive">
    <table class="table table-centered mb-0">
        <thead class="thead-light">
        <tr>
            <th><a class="text-light" style="text-decoration: underline"
                   href="{{ $links['id'] }}">@lang('lots.id')</a>
                @if($sort_by === 'id')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['name'] }}">@lang('lots.name')</a>
                @if($sort_by === 'name')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>@lang('lots.owner')</th>
            <th>@lang('lots.company')</th>
            <th><a class="text-light" style="text-decoration: underline"
                   href="{{ $links['pt_weight'] }}">@lang('lots.pt')</a>
                @if($sort_by === 'pt_weight')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif</th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['pd_weight'] }}">@lang('lots.pd')</a>
                @if($sort_by === 'pd_weight')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['rh_weight'] }}">@lang('lots.rh')</a>
                @if($sort_by === 'rh_weight')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th><a class="text-light" style="text-decoration: underline"
                   href="{{ $links['pt_rate'] }}">@lang('lots.r_pt')</a>
                @if($sort_by === 'pt_rate')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['pd_rate'] }}">@lang('lots.r_pd')</a>
                @if($sort_by === 'pd_rate')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['rh_rate'] }}">@lang('lots.r_rh')</a>
                @if($sort_by === 'rh_rate')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
        <!--            <th>@lang('lots.updated_at')</th>
            <th>@lang('lots.created_at')</th>-->
            <th style="width: 125px;">@lang('lots.action')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr>
                <td><a href="javascript: void(0);" class="text-body font-weight-bold">#{{$item->id}}</a></td>
                <td>{{$item->name}}</td>
                <td> {{($item->owner) ? $item->owner->fullname() : 'Неизвестно'}}</td>
                <td>{{($item->company) ? $item->company->name : 'Неизвестно'}}</td>
                <td>{{$item->pt_weight}}</td>
                <td>{{$item->pd_weight}}</td>
                <td>{{$item->rh_weight}}</td>
                <td>{{$item->pt_rate}}</td>
                <td>{{$item->pd_rate}}</td>
                <td>{{$item->rh_rate}}</td>
            <!--                <td>{{$item->updated_at}}</td>
                <td>{{$item->created_at}}</td>-->
                <td>
                    <a href="{{route('lots.info',$item->id)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                    @can('policy','guard_lots_edit|guard_lots_edit_self,'.$item->user_id)
                        <a href="{{route('lots.edit',$item->id)}}" class="action-icon"> <i
                                    class="mdi mdi-square-edit-outline"></i></a>
                    @endcan
                    @can('policy','guard_lots_delete|guard_lots_delete_self,'.$item->user_id)
                        <a href="{{route('lots.delete',$item->id)}}"
                           onclick="return confirm('{{__('index.confirmation')}}');" class="action-icon"> <i
                                    class="mdi mdi-delete"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
