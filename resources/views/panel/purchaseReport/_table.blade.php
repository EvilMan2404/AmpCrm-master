<div class="table-responsive">
    <table class="table table-centered mb-0">
        <thead class="thead-light">
        <tr>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['id'] }}">@lang('purchaseReports.id')</a>
                @if($sort_by === 'id')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['name'] }}">@lang('purchaseReports.name')</a>
                @if($sort_by === 'name')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                @lang('purchaseReports.date_start')
                -
                @lang('purchaseReports.date_finish')
            </th>
            <th>
                @lang('purchaseReports.owner')
            </th>
            <th>
                @lang('purchaseReports.stocks')
            </th>
            <th>
                @lang('purchaseReports.table.summary')
            </th>

            <th style="width: 125px;">@lang('purchaseReports.action')</th>
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
                    {{\Carbon\Carbon::parse($item->date_start)->format('d.m.Y')}}
                    -
                    {{\Carbon\Carbon::parse($item->date_finish)->format('d.m.Y')}}
                </td>
                <td>
                    <a href="{{route('purchaseReports.index',['owner' => $item->owner->id])}}">{{($item->owner) ? $item->owner->fullname() : ''}}</a>
                </td>
                <td>
                    <ul>

                        @foreach($item->stocks as $value)
                            <li>
                                <a href="{{route('stock.info',['id' => $value->id])}}">{{$value->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    {{$item->total ?? 0}} €
                </td>
                <td>
                    <a href="{{route('purchaseReports.download',$item->id)}}" target="_blank" class="action-icon"> <i
                                class="mdi mdi-download"></i></a>
                    @can('policy','guard_purchaseReports_edit|guard_purchaseReports_edit_self,'.$item->user_id)
                        <a href="{{route('purchaseReports.edit',$item->id)}}" class="action-icon"> <i
                                    class="mdi mdi-square-edit-outline"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
