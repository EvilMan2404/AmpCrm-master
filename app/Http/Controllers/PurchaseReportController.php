<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReport;
use App\Models\PurchaseReportHasWastes;
use App\Models\Stock;
use App\Models\User;
use App\Models\WasteTypes;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PDF;

class PurchaseReportController extends Controller
{
    /**
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $search = false;
        $data   = PurchaseReport::where(static function ($query) {
            if (\Gate::allows('policy', 'guard_purchaseReports_view')) {
                $query->where('space_id',
                    Auth::user()->space_id);
            } else {
                $query->where('user_id',
                    Auth::id());
            }
        })->where(static function ($query) use ($request) {
            if ($request->get('name')) {
                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
            }
            if ($request->get('owner')) {
                $query->where('user_id', $request->get('owner'));
            }
        });
        if ($request->get('name') || $request->get('status') || $request->get('owner')) {
            $search = true;
        }

        /*sorting rows*/
        $columns = ['name', 'pt', 'pd', 'rh', 'weight', 'total', 'id', 'updated_at'];
        if ($request->get('sort_by') && $request->get('order')) {
            $validation_get = Validator::make($request->all(), [
                'sort_by' => [Rule::in($columns)],
                'order'   => [Rule::in(['desc', 'asc'])],
            ]);
            $sort_by        = (string) $request->get('sort_by');
            $order          = (string) $request->get('order');
            if ($validation_get->passes()) {
                $data->orderBy($sort_by, $order);
                $search = true;
            } else {
                $data->orderByDesc('id');
            }
        } else {
            $data->orderByDesc('id');
        }
        /*end sorting rows*/
        $searchOwner = User::find($request->get('owner'));
        $path        = (new Helpers\HelpersController)->array2string($request->all()); // formatting url
        $links       = (new Helpers\HelpersController)->generateLinkForSorting($columns, $request);
        return view('panel.purchaseReport.index', [
            'data'        => $data->paginate(15),
            'path'        => $path,
            'searchName'  => $request->get('name'),
            'filters'     => $search,
            'searchOwner' => $searchOwner,
            'sort_by'     => $request->get('sort_by'),
            'order'       => $request->get('order'),
            'links'       => $links,
            'breadcrumb'  => [
                'title' => __('sidebar.reports.purchase'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('purchaseReports.index'),
                            'name'   => __('sidebar.reports.purchase'),
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }

    /**
     * @param  Request  $request
     * @param  int|null  $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function form(Request $request, ?int $id = null)
    {
        if ($id === null) {
            $title = __('purchaseReports.create');
            $model = new PurchaseReport();
        } else {
            $title = __('purchaseReports.edit');

            $model = PurchaseReport::where('id', $id)->with('stocks')->first();
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$model) {
            return redirect()->route('main');
        }

        if ($id && \Gate::denies('policy',
                'guard_purchaseReports_edit|guard_purchaseReports_edit_self,'.$model->user_id)) {
            abort(403);
        }

        $stocks          = $request->get('stocks');
        $stocks          = $stocks ? explode(',', $stocks) : [];
        $stockId         = count($model->stocks) > 0 ? $model->stocks : $stocks;
        $wastesUsedArray = $model->hasWastesArray() ?? [];
        $stockInfo       = array();
        if (\Gate::allows('policy', 'guard_stock_view|guard_stock_view_self')) {
            $stockInfo = Stock::where(static function ($query) {
                if (\Gate::allows('policy', 'guard_stock_view')) {
                    $query->where('space_id',
                        Auth::user()->space_id);
                } elseif (\Gate::allows('policy', 'guard_stock_view_self')) {
                    $query->where('user_id',
                        Auth::id());
                }
            })->whereIn('id', $stockId)->get();
        }
        $user_id  = old('user_id', $model->user_id);
        $userInfo = User::where('id', $user_id)->first();
        $lastweek = PurchaseReport::getPreviousWeek();
        return view('panel.purchaseReport.form', [
            'item'            => $model,
            'stockInfo'       => $stockInfo ?? new Stock(),
            'userInfo'        => $userInfo ?? new User(),
            'success'         => Session::get('success'),
            'attention'       => Session::get('attention'),
            'wastesUsedArray' => $wastesUsedArray,
            'lastweek'        => $lastweek,
            'wasteTypes'      => WasteTypes::whereSpaceId(Auth::user()->space_id)->get(),
            'breadcrumb'      => [
                'title' => $title,
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('purchaseReports.index'),
                            'name'   => __('sidebar.reports.purchase'),
                            'active' => false
                        ], [
                            'link'   => route('purchaseReports.create'),
                            'name'   => $title,
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }


    /**
     * @param  Request  $request
     * @param  int|null  $id
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function save(Request $request, ?int $id = null): RedirectResponse
    {
        $this->validate($request, [
            'name'          => 'required',
            'stocks'        => 'required',
            'stocks.*'      => [
                'required', 'exists:stock,id', static function ($attribute, $value, $fail) use ($request) {
                    $stocks = Stock::whereIn('id', $request->post('stocks'))->get();
                    if (count($stocks) !== count($request->post('stocks'))) {
                        $fail(__('purchaseReports.errors.exists'));
                    }
                    foreach ($stocks as $item) {
                        if ($item->user_id !== (int) $request->post('user_id')) {
                            $fail(__('purchaseReports.errors.exists'));
                        }
                    }
                }
            ],
            'user_id'       => 'required|exists:users,id',
            'waste_types'   => 'nullable',
            'waste_types.*' => 'nullable|exists:waste_types,id',
            'wastes_sum.*'  => [
                'nullable', 'numeric',
                static function ($attribute, $value, $fail) use ($request) {
                    $wastes = $request->post('waste_types');
                    $wastes = is_array($wastes) ? $wastes : [];
                    if ($wastes) {
                        foreach ($request->post('wastes_sum') as $key => $item) {
                            if (!in_array((int) $key, $wastes)) {
                                $fail(__('purchaseReports.errors.wastes'));
                            }
                        }
                    }
                }
            ]
        ], [
            'required'    => __('purchaseReports.errors.required'),
            'numeric'     => __('purchaseReports.errors.numeric'),
            'exists'      => __('purchaseReports.errors.exists'),
            'date'        => __('purchaseReports.errors.date'),
            'date_format' => __('purchaseReports.errors.date_format'),
        ]);


        if ($id === null) {
            $model          = new PurchaseReport();
            $model->user_id = Auth::id();
        } else {
            $model = PurchaseReport::find($id);
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$model) {
            return redirect()->route('main');
        }
        if ($id && \Gate::denies('policy',
                'guard_purchaseReports_edit|guard_purchaseReports_edit_self,'.$model->user_id)) {
            abort(403);
        } elseif (\Gate::denies('policy', 'guard_purchaseReports_add')) {
            abort(403);
        }

        $totalLots   = 0;
        $totalWastes = 0;
        if ($request->post('wastes_sum')) {
            foreach ($request->post('wastes_sum') as $item) {
                $totalWastes += $item;
            }
        }
        $stocks       = Stock::whereSpaceId(\Auth::user()->space_id)
            ->whereIn('id', $request->post('stocks'))->with('purchases')->get();
        $stocks_array = array();
        foreach ($stocks as $item) {
            $stocks_array[$item->id]['name']  = $item->name;
            $stocks_array[$item->id]['total'] = 0;
            foreach ($item->purchases as $value) {
                $stocks_array[$item->id]['total'] += $value->total;
                $totalLots                        += $value->total;
            }
        }
        \DB::transaction(static function () use ($model, $request, $id, $totalWastes, $totalLots, $stocks_array) {
            $lastweek           = PurchaseReport::getPreviousWeek();
            $model->name        = $request->post('name');
            $model->space_id    = Auth::user()->space_id;
            $model->user_id     = $request->post('user_id');
            $model->total_waste = $totalWastes;
            $model->total_lots  = $totalLots;
            $model->total       = $totalLots + $totalWastes;
            $model->history     = json_encode($stocks_array, JSON_THROW_ON_ERROR);
            $model->date_start  = $lastweek['start'];
            $model->date_finish = $lastweek['end'];
            $model->save();
            $model->stocks()->sync($request->post('stocks') ?? []);
            $model->wasteTypes()->sync($request->post('waste_types') ?? []);
            $wastes = $request->post('waste_types');
            if (is_array($wastes)) {
                foreach ($wastes as $waste) {
                    $value      = $request->post('wastes_sum')[$waste] ?? 0;
                    $wasteModel = PurchaseReportHasWastes::where('report_id', $model->id)->where('waste_id',
                        $waste)->first();
                    if ($wasteModel) {
                        $wasteModel->sum = (int) $value;
                        $wasteModel->save();
                    }
                }
            }
        });

        return redirect()->route('purchaseReports.edit', ['id' => $model->id])->with('success',
            __('purchaseReports.save'));
    }

    /**
     * @param $id
     * @throws \JsonException
     */

    public function download($id)
    {
        $model = PurchaseReport::find($id);
        if ($model && $model->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$model) {
            return redirect()->route('main');
        }
        if (\Gate::denies('policy', 'guard_purchaseReports_view|guard_purchaseReports_view_self,'.$model->user_id)) {
            abort(403);
        }
        view()->share('model', $model);
        $pdf = PDF::loadView('panel.purchaseReport.report_pdf', $model);
        // download PDF file with download method
        return $pdf->download('report_'.$id.'.pdf');
    }
}
