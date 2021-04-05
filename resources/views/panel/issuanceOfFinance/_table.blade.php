<div class="table-responsive">
    <table class="table table-centered mb-0">
        <thead class="thead-light">
        <tr>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['id'] }}">@lang('issuanceOfFinance.id')</a>
                @if($sort_by === 'id')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['name'] }}">@lang('issuanceOfFinance.name')</a>
                @if($sort_by === 'name')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>@lang('issuanceOfFinance.description')</th>
            <th>@lang('issuanceOfFinance.user_id')</th>
            <th>@lang('issuanceOfFinance.assigned_user')</th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['amount'] }} ">@lang('issuanceOfFinance.amount')</a>
                @if($sort_by === 'total')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>@lang('issuanceOfFinance.balance')</th>
            <th><a class="text-light" style="text-decoration: underline"
                   href="{{ $links['created_at'] }}">@lang('issuanceOfFinance.created_at')</a>
                @if($sort_by === 'created_at')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif</th>
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
                    {{$item->description}}
                </td>
                <td>
                    {{($item->assignedUserRelation) ? $item->assignedUserRelation->fullname() : 'Удален'}}
                </td>
                <td>
                    {{($item->userIdRelation) ? $item->userIdRelation->fullname() : 'Удален'}}
                </td>
                <td>
                    {{$item->amount}}
                </td>
                <td>
                    {{($item->userIdRelation && $item->balance === '0.00') ? $item->userIdRelation->balance : $item->balance}}
                </td>
                <td>
                    {{$item->created_at}}
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
