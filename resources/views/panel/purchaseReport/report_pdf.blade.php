<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REPORT {{$model->id}}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            margin-top: 50px;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
<div class="container">
    <div>
        <b>{{$model->name}}</b>
    </div>
    <div>
        {{\Carbon\Carbon::parse($model->date_start)->format('d.m.Y')}}
        -
        {{\Carbon\Carbon::parse($model->date_finish)->format('d.m.Y')}}
    </div>
    <div>
        @lang('purchaseReports.owner') : {{($model->owner) ? $model->owner->fullname() : 'Неизвестен'}}
    </div>
    <div>

        <table>
            <tr>
                <th> @lang('purchaseReports.table.nameStock')</th>
                <th> @lang('purchaseReports.table.totalStock')</th>
            </tr>
            @foreach(json_decode($model->history, true, 512, JSON_THROW_ON_ERROR) as $item)
                <tr>
                    <td>{{$item['name']}}</td>
                    <td>
                        {{$item['total']}} euro
                    </td>
                </tr>
            @endforeach

            <tr aria-colspan="2">
                <td>@lang('purchaseReports.table.summary')</td>
                <td>{{$model->total_lots}} euro</td>
            </tr>
        </table>

        <table>
            <tr>
                <th>@lang('purchaseReports.table.nameWaste')</th>
                <th>@lang('purchaseReports.table.wasteSum')</th>
            </tr>
            @foreach($model->hasWastes as $item)
                <tr>
                    <td>{{$item->waste->name}}</td>
                    <td>
                        {{$item->sum}} euro
                    </td>
                </tr>
            @endforeach
            <tr aria-colspan="2">
                <td>@lang('purchaseReports.table.summary')</td>
                <td>{{$model->total_waste}} euro</td>
            </tr>
        </table>

        <table>
            <tr>
                <td><b>@lang('purchaseReports.table.summary')</b></td>
                <td style="margin-left: auto">{{$model->total}} euro</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
