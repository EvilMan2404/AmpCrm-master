<?php


namespace App\Http\Controllers;


use App\Models\CarBrand;
use App\Models\Catalog;
use App\Models\Clients;
use App\Models\Discount;
use App\Models\Lots;
use App\Models\Purchase;
use App\Models\PurchasePaymentType;
use App\Models\PurchaseStatus;
use App\Models\User;
use App\Rules\CheckStatusAndUserBeforeTransfer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class CatalogController
 * @package App\Http\Controllers
 */
class PurchaseController extends Controller
{
    /**
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $search = false;
        $data   = Purchase::with(['status', 'lot'])->where(static function ($query) {
            if (\Gate::allows('policy', 'guard_purchase_view')) {
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
            if ($request->get('status')) {
                $query->where('status_id', $request->get('status'));
            }
            if ($request->get('owner')) {
                $query->where('user_id', $request->get('owner'));
            }
        });
        if ($request->get('name') || $request->get('status') || $request->get('owner')) {
            $search = true;
        }
        /* getting statuses for current catalogs*/
        $statuses = PurchaseStatus::whereSpaceId(Auth::user()->space_id)->whereHas('purchaseRelation',
            function (Builder $query) use ($request) {
                $query->when($request->get('name'), static function (Builder $query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->get('name').'%');
                })->when($request->get('status'), static function (Builder $query) use ($request) {
                    return $query->where('status_id', $request->get('status'));
                });
                if (\Gate::allows('policy', 'guard_purchase_view')) {
                    $query->where('space_id',
                        Auth::user()->space_id);
                } else {
                    $query->where('user_id',
                        Auth::id());
                }
            })->get();
        /* end getting statuses for current catalogs*/

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
        return view('panel.purchase.index', [
            'data'         => $data->paginate(15),
            'path'         => $path,
            'searchName'   => $request->get('name'),
            'searchStatus' => (int) $request->get('status'),
            'statuses'     => $statuses,
            'filters'      => $search,
            'searchOwner'  => $searchOwner,
            'sort_by'      => $request->get('sort_by'),
            'order'        => $request->get('order'),
            'links'        => $links,
            'breadcrumb'   => [
                'title' => __('sidebar.purchase'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('purchase.index'),
                            'name'   => __('sidebar.purchase'),
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
            $title = __('purchase.create');
            $model = new Purchase();
        } else {
            $title = __('purchase.edit');

            $model = Purchase::where('id', $id)->with('catalogs')->first();
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$model) {
            return redirect()->route('main');
        }

        if ($id && \Gate::denies('policy', 'guard_purchase_edit|guard_purchase_edit_self,'.$model->user_id)) {
            abort(403);
        }

        $lotId       = old('lot', $model->lot_id) ?? $request->get('lot_id');
        $lotInfo     = Lots::with('company')->where('id', $lotId)->first();
        $categories  = $request->get('categories_id');
        $categories  = $categories ? explode(',', $categories) : [];
        $catalogId   = count($model->categories) > 0 ? $model->categories : $categories;
        $catalogInfo = array();
        if (\Gate::allows('policy', 'guard_catalog_view|guard_catalog_view_self')) {
            $catalogInfo = Catalog::with('carIdRelation')->where(static function ($query) {
                if (\Gate::allows('policy', 'guard_catalog_view')) {
                    $query->where('space_id',
                        Auth::user()->space_id);
                } elseif (\Gate::allows('policy', 'guard_catalog_view_self')) {
                    $query->where('user_id',
                        Auth::id());
                }
            })->whereIn('id', $catalogId)->get();
        }
        $discount = Discount::where('space_id', Auth::user()->space_id)->first();

        $client_id  = old('client_id', $model->client_id);
        $userPaidId = old('user_paid', $model->user_paid_id);
        $clientInfo = Clients::where('id', $client_id)->first();
        $userPaid   = User::where('id', $userPaidId)->first();

        $isDoneStatus = false;
        if ($id && $model->status && $model->status->final) {
            $isDoneStatus = true;
        }
        return view('panel.purchase.form', [
            'brand'        => CarBrand::all(),
            'item'         => $model,
            'isDoneStatus' => $isDoneStatus,
            'lotInfo'      => $lotInfo ?? new Lots(),
            'catalogInfo'  => $catalogInfo ?? new Catalog(),
            'userPaid'     => $userPaid,
            'discount'     => $discount ?? new Discount(),
            'clientInfo'   => $clientInfo,
            'success'      => Session::get('success'),
            'attention'    => Session::get('attention'),
            'statuses'     => PurchaseStatus::whereSpaceId(Auth::user()->space_id)->get(),
            'paymentTypes' => PurchasePaymentType::whereSpaceId(Auth::user()->space_id)->get(),
            'breadcrumb'   => [
                'title' => $title,
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('purchase.index'),
                            'name'   => __('sidebar.purchase'),
                            'active' => false
                        ], [
                            'link'   => route('purchase.create'),
                            'name'   => $title,
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function view(Request $request, int $id)
    {
        $data = Purchase::where('id', $id)->first();
        if ($data && $data->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$data) {
            return redirect(route('main'));
        }
        if (\Gate::denies('policy', 'guard_purchase_view|guard_purchase_view_self,'.$data->user_id)) {
            abort(403);
        }
        $lotId       = $data->lot_id;
        $lotInfo     = Lots::with('company')->where('id', $lotId)->first();
        $catalogId   = $data->categories;
        $catalogInfo = Catalog::with('carIdRelation')->whereIn('id', $catalogId)->get();
        $discount    = Discount::where('space_id', Auth::user()->space_id)->first();
        return view('panel.purchase.view', [
            'brand'       => CarBrand::all(),
            'item'        => $data,
            'lotInfo'     => $lotInfo,
            'catalogInfo' => $catalogInfo,
            'discount'    => $discount,
            'success'     => Session::get('success'),
            'breadcrumb'  => [
                'title' => $data->name,
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('purchase.index'),
                            'name'   => __('sidebar.purchase'),
                            'active' => false
                        ], [
                            'link'   => route('purchase.view', $id),
                            'name'   => $data->name,
                            'active' => false
                        ],
                    ]
            ]
        ]);
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request, int $id): RedirectResponse
    {
        $purchase = Purchase::where('id', $id)->first();
        if ($purchase && $purchase->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$purchase) {
            return redirect(route('main'));
        }
        if (\Gate::denies('policy', 'guard_purchase_delete|guard_purchase_delete_self,'.$purchase->user_id)) {
            abort(403);
        }
        $purchase->delete();
        return redirect()->route('purchase.index')->with('success', __('purchase.deleted'));
    }

    /**
     * @param  Request  $request
     * @param  int|null  $id
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function save(Request $request, ?int $id = null): RedirectResponse
    {
        $validator = Validator::make($request->post(), [
            'name'         => 'required',
            'categories'   => 'required',
            'status_id'    => [
                'required', 'exists:purchase_status,id', new CheckStatusAndUserBeforeTransfer($request, $id)
            ],
            'type_payment' => 'required|exists:purchase_payment_types,id',
            'client_id'    => 'nullable|exists:clients,id',
            'user_paid'    => 'required|exists:users,id',
            'paid'         => 'nullable|numeric',
            'paid_card'    => 'nullable|numeric',
            'lot'          => [
                'required', 'exists:lots,id',
                static function ($attribute, $value, $fail) use ($request) {
                    $categories = $request->post('categories');
                    $categories = is_array($categories) ? $categories : [];
                    if (!Purchase::checkLots($categories, (int) $value)) {
                        $fail(__('purchase.errors.lots_weight'));
                    }
                }
            ]
        ], [
            'name.required'         => __('purchase.errors.name'),
            'paid.required'         => __('purchase.errors.paid'),
            'status_id.required'    => __('purchase.errors.status_required'),
            'status_id.exists'      => __('purchase.errors.status_exists'),
            'categories.required'   => __('purchase.errors.categories'),
            'lot.required'          => __('purchase.errors.lots_required'),
            'lot.exists'            => __('purchase.errors.lots_exists'),
            'client_id.exists'      => __('purchase.errors.client'),
            'user_paid.exists'      => __('purchase.errors.user_paid'),
            'user_paid.required'    => __('purchase.errors.user_paid'),
            'client_id.required'    => __('purchase.errors.client'),
            'type_payment.required' => __('purchase.errors.type_payment'),
            'type_payment.in'       => __('purchase.errors.type_payment'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($id === null) {
            $model          = new Purchase();
            $model->user_id = Auth::id();
        } else {
            $model = Purchase::find($id);
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$model) {
            return redirect()->route('main');
        }
        if ($id && \Gate::denies('policy', 'guard_purchase_edit|guard_purchase_edit_self,'.$model->user_id)) {
            abort(403);
        } elseif (\Gate::denies('policy', 'guard_purchase_add')) {
            abort(403);
        }
        $isDoneStatus = false;
        if ($id && $model->status && $model->status->final) {
            $isDoneStatus = true;
        }
        \DB::transaction(static function () use ($model, $request, $isDoneStatus) {
            $model->name         = $request->post('name');
            $model->description  = $request->post('description');
            $model->user_paid_id = (int) $request->post('user_paid');


            if (!$isDoneStatus) {
                $model->type_payment  = $request->post('type_payment');
                $model->client_id     = $request->post('client_id');
                $model->lot_id        = $request->post('lot');
                $model->space_id      = Auth::user()->space_id;
                $model->status_id     = $request->post('status_id');
                $lots                 = Lots::find($request->post('lot'));
                $discount             = Discount::where('space_id', Auth::user()->space_id)->first();
                $discount             = $discount ?? new Discount();
                $cat                  = is_array($request->post('cat')) ? $request->post('cat') : [];
                $categoriesData       = is_array($request->post('categories')) ? $request->post('categories') : [];
                $calc                 = Catalog::calcCategoriesMetal($categoriesData, $lots, $discount,
                    $cat);
                $lots->pd_weight_used += $calc['pd'];
                $lots->pt_weight_used += $calc['pt'];
                $lots->rh_weight_used += $calc['rh'];
                $model->pd            = $calc['pd'];
                $model->pt            = $calc['pt'];
                $model->rh            = $calc['rh'];
                $model->weight        = $calc['weight'];
                $model->total         = $model->countTotal($calc['price'], ((int) $discount->purchase_discount / 100));
                $lots->save();
            }
            $statusInfo = PurchaseStatus::find($model->status_id);
            if ($model->user_paid_id === (int) Auth::id() && (float) $model->getOriginal('paid') < (float) $request->post('paid') && $statusInfo && $statusInfo->final) {
                $model->paid = (float) $request->post('paid');
            }
            if ($model->user_paid_id === (int) Auth::id() && $model->isDirty('paid') && (float) $model->getOriginal('paid') < $model->paid) {
                $amount = $model->paid - (float) $model->getOriginal('paid');
                if ($statusInfo && $statusInfo->final) {
                    User::transferMoney(Auth::id(), $amount, User::OUTBOX);
                }
            }
            if ($model->user_paid_id === (int) Auth::id() && (float) $model->getOriginal('paid_card') < (float) $request->post('paid_card') && $statusInfo && $statusInfo->final) {
                $model->paid_card = (float) $request->post('paid_card');
            }
            if ($model->user_paid_id === (int) Auth::id() && $model->isDirty('paid_card') && (float) $model->getOriginal('paid_card') < $model->paid_card) {
                $amount = $model->paid_card - (float) $model->getOriginal('paid_card');
                if ($statusInfo && $statusInfo->final) {
                    User::transferMoney(Auth::id(), $amount, User::OUTBOX);
                }
            }

            $model->save();
            if (!$isDoneStatus) {
                $model->catalogs()->sync($cat);
            }
        });

        return redirect()->route('purchase.edit', ['id' => $model->id])->with('success',
            ($isDoneStatus) ? __('purchase.savedPartly') : __('purchase.save'));
    }
}
