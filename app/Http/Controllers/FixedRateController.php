<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Lots;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FixedRateController extends Controller
{
    public bool $inPurchase = false;

    public function index(Request $request)
    {
        $search = false;
        $data   = Lots::where(static function ($query) {
            if (\Gate::allows('policy', 'guard_lots_view')) {
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
            if ($request->get('company')) {
                $query->where('company_id', $request->get('company'));
            }
            if ($request->get('assigned')) {
                $query->where('assigned_user', $request->get('assigned'));
            }
            if ($request->get('owner')) {
                $query->where('user_id', $request->get('owner'));
            }
        });
        if ($request->get('name') || $request->get('company') || $request->get('assigned') || $request->get('owner')) {
            $search = true;
        }


        /*sorting rows*/
        $columns = [
            'id', 'name', 'pt_weight', 'pd_weight', 'pt_rate', 'rh_weight', 'pd_rate', 'rh_rate'
        ];
        if ($request->get('sort_by') && $request->get('order')) {
            $validation_get = Validator::make($request->all(), [
                'sort_by' => [
                    Rule::in($columns)
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

        $links          = (new Helpers\HelpersController)->generateLinkForSorting($columns, $request);
        $searchCompany  = Company::find($request->get('company'));
        $searchAssigned = User::find($request->get('assigned'));
        $searchOwner    = User::find($request->get('owner'));
        return view('panel.lots.index', [
            'data'           => $data->paginate(15),
            'path'           => $path,
            'searchName'     => $request->get('name') ?? '',
            'searchCompany'  => $searchCompany,
            'searchAssigned' => $searchAssigned,
            'searchOwner'    => $searchOwner,
            'filters'        => $search,
            'sort_by'        => $request->get('sort_by'),
            'order'          => $request->get('order'),
            'links'          => $links,
            'breadcrumb'     => [
                'title' => __('sidebar.fixPrice'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('lots.index'),
                            'name'   => __('sidebar.fixPrice'),
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }

    public function view(int $id)
    {
        $data = Lots::where('id', $id)->first();
        if ($data && $data->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$data) {
            return redirect()->route('main');
        }
        if (\Gate::denies('policy', 'guard_lots_view|guard_lots_view_self,'.$data->user_id)) {
            abort(403);
        }
        $this->checkPurchase($data->id);

        return view('panel.lots.view', [
            'item'       => $data,
            'inPurchase' => $this->inPurchase,
            'breadcrumb' => [
                'title' => $data->name,
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('lots.index'),
                            'name'   => __('sidebar.fixPrice'),
                            'active' => false
                        ], [
                            'link'   => route('lots.info', $data->id),
                            'name'   => $data->name,
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }

    public function checkPurchase($id): void
    {
        if (Purchase::where('lot_id', $id)->where('space_id', Auth::user()->space_id)->count() > 0) {
            $this->inPurchase = true;
        }
    }

    public function form(?int $id = null)
    {
        if ($id === null) {
            $title = __('lots.create');
            $model = new Lots();
        } else {
            $title = __('lots.edit');

            $model = Lots::where('id', $id)->first();
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
            $this->checkPurchase($model->id);
        }
        if (!$model) {
            return redirect()->route('main');
        }
        if ($id && \Gate::denies('policy', 'guard_lots_edit|guard_lots_edit_self,'.$model->user_id)) {
            abort(403);
        }
        return view('panel.lots.form', [
            'item'       => $model,
            'inPurchase' => $this->inPurchase,
            'breadcrumb' => [
                'title' => $title,
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('lots.index'),
                            'name'   => __('sidebar.fixPrice'),
                            'active' => false
                        ], [
                            'link'   => route('lots.create'),
                            'name'   => __('lots.create'),
                            'active' => true
                        ],
                    ]
            ],
        ]);
    }

    /**
     * @param  Request  $request
     * @param  int|null  $id
     * @return RedirectResponse
     */
    public function save(Request $request, ?int $id = null): RedirectResponse
    {
        $this->validateFields($request, $id);
        if ($id === null) {
            $model = new Lots();
        } else {
            $model = Lots::find($id);
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
            $this->checkPurchase($model->id);
        }
        if (!$model) {
            return redirect()->route('main');
        }
        if ($id && \Gate::denies('policy', 'guard_lots_edit|guard_lots_edit_self,'.$model->user_id)) {
            abort(403);
        } elseif (\Gate::denies('policy', 'guard_lots_add')) {
            abort(403);
        }
        $model->name        = $request->post('name');
        $model->description = $request->post('description') ?? '';
        if (!$this->inPurchase) {
            $model->pt_weight = $request->post('pt_weight');
            $model->pd_weight = $request->post('pd_weight');
            $model->rh_weight = $request->post('rh_weight');
            $model->pt_rate   = $request->post('pt_rate');
            $model->pd_rate   = $request->post('pd_rate');
            $model->rh_rate   = $request->post('rh_rate');
        }
        $model->company_id = $request->post('company_id');
        if ($id === null || ($model->user_id === Auth::id())) {
            $model->assigned_user = $request->post('assigned_user') ?? Auth::id();
        }
        if ($id === null) {
            $model->user_id  = Auth::id();
            $model->space_id = Auth::user()->space_id;
        }
        $model->save();
        return redirect()->route('lots.index')->with('success', __('lots.save'));
    }

    public function delete(Request $request, int $id)
    {
        $lot = Lots::where('id', $id)->first();
        if ($lot && $lot->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$lot) {
            return redirect()->route('main');
        }
        if (\Gate::denies('policy', 'guard_lots_delete|guard_lots_delete_self,'.$lot->user_id)) {
            abort(403);
        }
        $lot->delete();
        return redirect()->route('lots.index')->with('success', __('lots.deleted'));
    }

    public function validateFields($request, $id)
    {
        $messages = [
            'name'       => __('lots.errors.name'),
            'pt_weight'  => __('lots.errors.pt'),
            'pd_weight'  => __('lots.errors.pd'),
            'rh_weight'  => __('lots.errors.rh'),
            'pt_rate'    => __('lots.errors.r_pt'),
            'pd_rate'    => __('lots.errors.r_pd'),
            'rh_rate'    => __('lots.errors.r_rh'),
            'company_id' => __('lots.errors.company'),
        ];
        if ($id === null) {
            $this->validate($request, [
                'name'          => 'required',
                'pt_weight'     => 'required|numeric|min:0',
                'pd_weight'     => 'required|numeric|min:0',
                'rh_weight'     => 'required|numeric|min:0',
                'pt_rate'       => 'required|numeric|min:0',
                'rh_rate'       => 'required|numeric|min:0',
                'pd_rate'       => 'required|numeric|min:0',
                'company_id'    => 'required|numeric|exists:company,id',
                'assigned_user' => 'nullable|numeric|exists:users,id',
            ], $messages);
        } else {
            $this->validate($request, [
                'name'          => 'required',
                'pt_weight'     => 'nullable|numeric|min:0',
                'pd_weight'     => 'nullable|numeric|min:0',
                'rh_weight'     => 'nullable|numeric|min:0',
                'pt_rate'       => 'nullable|numeric|min:0',
                'rh_rate'       => 'nullable|numeric|min:0',
                'pd_rate'       => 'nullable|numeric|min:0',
                'company_id'    => 'required|numeric|exists:company,id',
                'assigned_user' => 'nullable|numeric|exists:users,id',
            ], $messages);
        }
    }
}
