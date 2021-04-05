<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\HelpersController;
use App\Models\Clients;
use App\Models\Purchase;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StockController extends Controller
{
    /**
     * @param  Request  $request
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = false;
        $data   = Stock::with(['userRelation'])->where(static function ($query) {
            if (\Gate::allows('policy', 'guard_stock_view')) {
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
            if ($request->get('date')) {
                $query->where('date', 'LIKE', '%'.$request->get('date').'%');
            }
            if ($request->get('owner')) {
                $query->where('user_id', $request->get('owner'));
            }
        });
        if ($request->get('owner')) {
            $searchOwner = User::where('space_id', Auth::user()->space_id)->where('id',
                (int) $request->get('owner'))->first();
        }
        if ($request->get('owner') || $request->get('date') || $request->get('name')) {
            $search = true;
        }
        /*sorting rows*/
        if ($request->get('sort_by') && $request->get('order')) {
            $validation_get = Validator::make($request->all(), [
                'sort_by' => [
                    Rule::in(
                        [
                            'name', 'date', 'id', 'weight_ceramics', 'analysis_pt', 'analysis_pd', 'analysis_rh',
                            'metallic', 'catalyst', 'analysis_dust_pt', 'analysis_dust_pd', 'analysis_dust_rh',
                            'weight_dust'
                        ])
                ],
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
        $path = (new Helpers\HelpersController)->array2string($request->all()); // formatting url
        return view('panel.stock.index', [
            'data'        => $data->paginate(15),
            'path'        => $path,
            'searchName'  => $request->get('name'),
            'searchDate'  => $request->get('date'),
            'searchOwner' => $searchOwner ?? '',
            'filters'     => $search,
            'breadcrumb'  => [
                'title' => __('sidebar.warehouse'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('stock.index'),
                            'name'   => __('sidebar.warehouse'),
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }

    /**
     * @param  int  $id
     * @return Application|Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */

    public function view(int $id)
    {
        $data = Stock::with('userRelation')->where('id',
            $id)->first();
        if ($data && $data->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$data) {
            return redirect()->route('main');
        }
        if (\Gate::denies('policy', 'guard_stock_view|guard_stock_view_self,'.$data->user_id)) {
            abort(403);
        }
        return view('panel.stock.view', [
            'item'       => $data,
            'breadcrumb' => [
                'title' => __('stock.view'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('stock.index'),
                            'name'   => __('sidebar.warehouse'),
                            'active' => false
                        ], [
                            'link'   => route('stock.info', $data->id),
                            'name'   => $data->name,
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }

    /**
     * @param  Request  $request
     * @param  int|null  $id
     * @return Application|Factory|\Illuminate\Contracts\View\View|RedirectResponse
     * @throws \JsonException
     */
    public function form(Request $request, ?int $id = null)
    {
        if ($id === null) {
            $title = __('stock.create');
            $model = new Stock();
        } else {
            $title = __('stock.edit');

            $model = Stock::with(['userRelation'])->where('id', $id)->first();
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$model) {
            return redirect()->route('main');
        }
        if ($id && \Gate::denies('policy', 'guard_stock_edit|guard_stock_edit_self,'.$model->user_id)) {
            abort(403);
        }
        $owner    = old('owner', $model->owner);
        $user_id  = old('user_id', $model->user_id);
        $userInfo = array();
        if ($owner) {
            $userInfo = $owner::find($user_id);
        }

        /*if (\Gate::allows('policy', 'guard_users_view|guard_users_view_self')) {
            $userInfo = User::where(static function ($query) {
                if (\Gate::allows('policy', 'guard_users_view')) {
                    $query->where('space_id',
                        Auth::user()->space_id);
                } elseif (\Gate::allows('policy', 'guard_users_view_self')) {
                    $query->where('assigned_user',
                        Auth::id());
                }
            })->where('id', $user_id)->first();
        }*/

        if (!$id) {
            $purchases = $request->get('purchases');
            $purchases = $purchases ? explode(',', $purchases) : [];
        }
        $purchasesId   = count($model->purchases) > 0 ? $model->purchases->pluck('id')->toArray() : $purchases ?? array();
        $purchasesInfo = Purchase::with('catalogs')->whereIn('id', $purchasesId)->get();
        $analysis      = json_decode($model->analysis, true);
        $ceramic       = (isset($analysis['ceramic_analysis']) ? json_decode($analysis['ceramic_analysis'], true) : []);
        $dust          = (isset($analysis['dust_analysis']) ? json_decode($analysis['dust_analysis'], true) : []);

        if (!$id) {
            HelpersController::countPurchases($purchasesInfo, $model);
        }

        return view('panel.stock.form', [
            'item'          => $model,
            'userInfo'      => $userInfo,
            'ceramic'       => is_array($ceramic) ? $ceramic : [],
            'dust'          => is_array($dust) ? $dust : [],
            'purchasesInfo' => $purchasesInfo,
            'breadcrumb'    => [
                'title' => $title,
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('stock.index'),
                            'name'   => __('sidebar.warehouse'),
                            'active' => true
                        ], [
                            'link'   => route('stock.create'),
                            'name'   => __('stock.create'),
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
     * @throws \Illuminate\Validation\ValidationException
     * @throws \JsonException
     */
    public function save(Request $request, ?int $id = null): RedirectResponse
    {
        $this->validateFields($request, $id);
        if ($id === null) {
            $stockLot = new Stock();
        } else {
            $stockLot = Stock::find($id);
            if ($stockLot && $stockLot->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$stockLot) {
            return redirect()->route('main');
        }

        if ($id && \Gate::denies('policy', 'guard_stock_edit|guard_stock_edit_self,'.$stockLot->user_id)) {
            abort(403);
        } elseif (\Gate::denies('policy', 'guard_stock_add')) {
            abort(403);
        }

        $stockLot->name = $request->post('name');
        $stockLot->date = $request->post('date');
        $purchasesInfo  = Purchase::with('catalogs')->whereIn('id', $request->post('purchases'))->get();
        HelpersController::countPurchases($purchasesInfo, $stockLot);
        $stockLot->metallic    = $request->post('metallic');
        $stockLot->weight_dust = $request->post('weight_dust');
        $stockLot->user_id     = $request->post('user_id');
        $stockLot->space_id    = Auth::user()->space_id;
        $stockLot->owner       = $request->post('owner');
        $stockLot->analysis    = json_encode([
            'ceramic_analysis' => json_encode($request->post('ceramic_analysis'), JSON_THROW_ON_ERROR),
            'dust_analysis'    => json_encode($request->post('dust_analysis'), JSON_THROW_ON_ERROR)
        ]);
        $stockLot->save();
        $stockLot->purchases()->sync($request->post('purchases'));
        return redirect()->route('stock.index')->with('success', __('stock.save'));
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request, int $id): RedirectResponse
    {
        $stock = Stock::where('id', $id)->first();
        if ($stock && $stock->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$stock) {
            return redirect()->route('main');
        }

        if (\Gate::denies('policy', 'guard_stock_delete|guard_stock_delete_self,'.$stock->user_id)) {
            abort(403);
        }

        $stock->delete();
        return redirect()->route('stock.index')->with('success', __('stock.deleted'));
    }

    /**
     * @param $request
     * @param $id
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateFields($request, $id)
    {
        $messages = [
            'name.required'             => __('stock.errors.name'),
            'date.required'             => __('stock.errors.date'),
            'date.date'                 => __('stock.errors.name'),
            'weight_ceramics.required'  => __('stock.errors.ceramic'),
            'weight_ceramics.numeric'   => __('stock.errors.ceramic'),
            'analysis_pt.numeric'       => __('stock.errors.ceramic_analysis_pt'),
            'analysis_pt.required'      => __('stock.errors.ceramic_analysis_pt'),
            'analysis_pd.required'      => __('stock.errors.ceramic_analysis_pd'),
            'analysis_pd.numeric'       => __('stock.errors.ceramic_analysis_pd'),
            'analysis_rh.numeric'       => __('stock.errors.ceramic_analysis_rh'),
            'analysis_rh.required'      => __('stock.errors.ceramic_analysis_rh'),
            'metallic.required'         => __('stock.errors.metallic'),
            'catalyst.required'         => __('stock.errors.catalyst'),
            'metallic.numeric'          => __('stock.errors.metallic'),
            'catalyst.numeric'          => __('stock.errors.catalyst'),
            'weight_dust.numeric'       => __('stock.errors.dust'),
            'weight_dust.required'      => __('stock.errors.dust'),
            'analysis_dust_pt.required' => __('stock.errors.dust_analysis_pt'),
            'analysis_dust_pt.numeric'  => __('stock.errors.dust_analysis_pt'),
            'analysis_dust_pd.required' => __('stock.errors.dust_analysis_pd'),
            'analysis_dust_pd.numeric'  => __('stock.errors.dust_analysis_pd'),
            'analysis_dust_rh.required' => __('stock.errors.dust_analysis_rh'),
            'analysis_dust_rh.numeric'  => __('stock.errors.dust_analysis_rh'),
            'user_id.numeric'           => __('stock.errors.user_id'),
            'user_id.exists'            => __('stock.errors.user_id'),
            'purchases.required'        => __('stock.errors.purchases'),
            'purchases.*.exists'        => __('stock.errors.purchases'),
        ];
        if ($id === null) {
            $this->validate($request, [
                'name'        => 'required',
                'date'        => 'required|date|date_format:Y-m-d',
                'weight_dust' => 'required|numeric',
                'metallic'    => 'required|numeric',
                'purchases'   => 'required',
                'purchases.*' => 'required|exists:purchase,id',
                'owner'       => ['required', Rule::in(User::class, Clients::class)],
                'user_id'     => [
                    'required', 'numeric', static function ($attribute, $value, $fail) use ($request) {
                        $class = $request->post('owner');
                        if (!$class::find($value)) {
                            $fail('The '.$attribute.' is invalid.');
                        }
                    },
                ],
            ],
                $messages
            );
        } else {
            $this->validate($request, [
                'name'        => 'required',
                'date'        => 'required|date',
                'weight_dust' => 'required|numeric',
                'metallic'    => 'required|numeric',
                'purchases'   => 'required',
                'owner'       => ['required', Rule::in(User::class, Clients::class)],
                'purchases.*' => 'required|exists:purchase,id',
                'user_id'     => [
                    'required', 'numeric', static function ($attribute, $value, $fail) use ($request) {
                        $class = $request->post('owner');
                        if (!$class::find($value)) {
                            $fail('The '.$attribute.' is invalid.');
                        }
                    },
                ],
            ],
                $messages
            );
        }
    }


}
