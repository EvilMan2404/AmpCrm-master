<div class="table-responsive">
    <table class="table table-centered mb-0">
        <thead class="thead-light">
        <tr>
            @if(!empty($searchOwner))
                <th style="width: 20px;">
                    #
                </th>
            @endif
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['id'] }}">@lang('purchase.id')</a>
                @if($sort_by === 'id')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['name'] }}">@lang('purchase.name')</a>
                @if($sort_by === 'name')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>@lang('purchase.description')</th>
            <th>@lang('purchase.status')</th>
            <th>@lang('purchase.pt-course')</th>
            <th>@lang('purchase.pd-course')</th>
            <th>@lang('purchase.rh-course')</th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['pt'] }}">@lang('purchase.pt')</a>
                @if($sort_by === 'pt')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['pd'] }}">@lang('purchase.pd')</a>
                @if($sort_by === 'pd')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['rh'] }}">@lang('purchase.rh')</a>
                @if($sort_by === 'rh')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['total'] }} ">@lang('purchase.table.total_price')</a>
                @if($sort_by === 'total')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>@lang('purchase.created at')</th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['updated_at'] }}">@lang('purchase.updated at')</a>
                @if($sort_by === 'updated_at')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th style="width: 125px;">@lang('purchase.action')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr>
                @if(!empty($searchOwner))
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input
                                    data-id="{{$item->id}}"
                                    type="checkbox" class="custom-control-input cart-check" id="check-{{$item->id}}">
                            <label class="custom-control-label" for="check-{{$item->id}}">&nbsp;</label>
                        </div>
                    </td>
                @endif
                <td><a href="javascript: void(0);" class="text-body font-weight-bold">#{{$item->id}}</a></td>
                <td>
                    {{$item->name}}
                </td>
                <td>
                    {{$item->description}}
                </td>
                <td>
                    {{$item->status->name??''}}
                </td>
                <td>
                    {{$item->lot->pt_rate??''}}
                </td>
                <td>
                    {{$item->lot->pd_rate??''}}
                </td>
                <td>
                    {{$item->lot->rh_rate??''}}
                </td>

                <td>
                    {{$item->pt}}
                </td>
                <td>
                    {{$item->pd}}
                </td>
                <td>
                    {{$item->rh}}
                </td>
                <td>
                    {{$item->total}}
                </td>
                <td>
                    {{$item->created_at->format('Y-m-d H:i')}}
                </td>
                <td>
                    {{$item->updated_at->format('Y-m-d H:i')}}
                </td>

                <td>
                    <a href="{{route('purchase.view',$item->id)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                    @can('policy','guard_purchase_edit|guard_purchase_edit_self,'.$item->user_id)
                        <a href="{{route('purchase.edit',$item->id)}}" class="action-icon"> <i
                                    class="mdi mdi-square-edit-outline"></i></a>
                    @endcan
                    @can('policy','guard_purchase_delete|guard_purchase_delete_self,'.$item->user_id)
                        <a href="{{route('purchase.delete',$item->id)}}"
                           onclick="return confirm('{{__('index.confirmation')}}');" class="action-icon"> <i
                                    class="mdi mdi-delete"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
