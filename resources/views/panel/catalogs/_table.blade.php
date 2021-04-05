<div class="table-responsive">
    <table class="table table-centered mb-0">
        <thead class="thead-light">
        <tr>
            @if(!empty($lot->id))
                <th style="width: 20px;">
                    #
                </th>
            @endif
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['id'] }} ">@lang('catalog.id')</a>
                @if($sort_by === 'id')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif

            </th>
            <th>@lang('catalog.image')</th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['name'] }}">@lang('catalog.name')</a>
                @if($sort_by === 'name')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>@lang('catalog.description')</th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['car_brand'] }}">@lang('catalog.car_brand')</a>
                @if($sort_by === 'car_brand')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['serial_number'] }}">@lang('catalog.serial_number')</a>
                @if($sort_by === 'serial_number')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>

            <th>@lang('catalog.editor')
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['pt'] }}">@lang('catalog.pt')</a>
                @if($sort_by === 'pt')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['pd'] }}">@lang('catalog.pd')</a>
                @if($sort_by === 'pd')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['rh'] }}">@lang('catalog.rh')</a>
                @if($sort_by === 'rh')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            <th>
                <a class="text-light" style="text-decoration: underline"
                   href="{{ $links['weight'] }}">@lang('catalog.weight')</a>
                @if($sort_by === 'weight')
                    @if($order === 'asc') ↑ @else
                        ↓ @endif
                @endif
            </th>
            @if($lot)
                <th>@lang('catalog.price')</th>
            @endif
            <th style="width: 125px;">@lang('catalog.action')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr>
                @if(!empty($lot->id))
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input
                                    data-id="{{$item->id}}"
                                    data-pt="{{$item->pt}}"
                                    data-pd="{{$item->pd}}"
                                    data-rh="{{$item->rh}}"
                                    data-weight="{{$item->weight}}"
                                    type="checkbox" class="custom-control-input cart-check" id="check-{{$item->id}}">
                            <label class="custom-control-label" for="check-{{$item->id}}">&nbsp;</label>
                        </div>
                    </td>
                @endif
                <td><a href="javascript: void(0);" class="text-body font-weight-bold">#{{$item->id}}</a></td>
                <td>
                    @foreach($item->files as $file)
                        <a href="/images/{{$file->file}}" data-fancybox="gallery-{{$item->id}}"
                           data-caption="{{$file->name}}">
                            <img src="/images/{{$file->file}}" height="32"/>
                        </a>
                    @endforeach

                </td>
                <td>
                    {{$item->name}}
                </td>
                <td>
                    {{$item->description}}
                </td>
                <td>
                    @if($item->carIdRelation){{$item->carIdRelation->name}}@endif
                </td>
                <td>
                    {{$item->serial_number}}
                </td>
                <td>
                    {{$item->updated_at}} {!!  (isset($item->editor)) ? '<br> by <a href="'.route('users.info',$item->editor->id).'">'.$item->editor->fullname().'</a>' : ''!!}
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
                    {{$item->weight}}
                </td>
                @if($lot)
                    <td style="color: #6658dd;">{{$item->getPrice($lot,$discount,[],$discount->purchase_discount)}}</td>
                @endif
                <td>
                    <a href="{{route('catalog.info',$item->id)}}" class="action-icon"> <i
                                class="mdi mdi-eye"></i></a>

                    @can('policy','guard_catalog_edit|guard_catalog_edit_self,'.$item->user_id)
                        <a href="{{route('catalog.edit',$item->id)}}" class="action-icon"> <i
                                    class="mdi mdi-square-edit-outline"></i></a>
                    @endcan

                    @can('policy','guard_catalog_delete|guard_catalog_delete_self,'.$item->user_id)
                        <a href="{{route('catalog.delete',$item->id)}}"
                           onclick="return confirm('{{__('index.confirmation')}}');" class="action-icon"> <i
                                    class="mdi mdi-delete"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>

