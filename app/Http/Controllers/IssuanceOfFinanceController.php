<?php

namespace App\Http\Controllers;

use App\Models\IssuanceOfFinance;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class IssuanceOfFinanceController extends Controller
{
    /**
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $search = false;
        $data   = IssuanceOfFinance::whereSpaceId(\Auth::user()->space_id)->where(static function ($query) use ($request
        ) {
            if ($request->get('name')) {
                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
            }
        });
        if ($request->get('name')) {
            $search = true;
        }
        /*sorting rows*/
        $columns = ['id', 'name', 'amount', 'created_at'];
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
        $path  = (new Helpers\HelpersController)->array2string($request->all()); // formatting url
        $links = (new Helpers\HelpersController)->generateLinkForSorting($columns, $request);
        return view('panel.issuanceOfFinance.index', [
            'data'       => $data->paginate(15),
            'filters'    => $search,
            'path'       => $path,
            'links'      => $links,
            'sort_by'    => $request->get('sort_by'),
            'order'      => $request->get('order'),
            'searchName' => $request->get('name'),
            'breadcrumb' => [
                'title' => __('sidebar.salary'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('industry.index'),
                            'name'   => __('sidebar.salary'),
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
            $title = __('issuanceOfFinance.create');
            $model = new IssuanceOfFinance();
        } else {
            $title = __('issuanceOfFinance.edit');

            $model = IssuanceOfFinance::where('id', $id)->first();
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$model) {
            return redirect()->route('main');
        }
        $assigned_id  = old('assigned_user', $model->assigned_user);
        $assignedInfo = User::where('id', $assigned_id)->first();
        return view('panel.issuanceOfFinance.form', [
            'item'             => $model,
            'assignedUserInfo' => $assignedInfo ?? new User(),
            'breadcrumb'       => [
                'title' => $title,
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('issuanceOfFinance.index'),
                            'name'   => __('sidebar.salary'),
                            'active' => false
                        ], [
                            'link'   => route('issuanceOfFinance.create'),
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
        $validator = Validator::make($request->post(), [
            'name'    => 'required',
            'user_id' => 'required|numeric|exists:users,id',
            'amount'  => 'required|numeric',
        ], [
            'required' => __('issuanceOfFinance.errors.required'),
            'numeric'  => __('issuanceOfFinance.errors.numeric'),
            'exists'   => __('issuanceOfFinance.errors.exists'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($id === null) {
            $model = new IssuanceOfFinance();
        } else {
            $model = IssuanceOfFinance::find($id);
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        \DB::transaction(static function () use ($model, $request) {
            $model->name          = $request->post('name');
            $model->assigned_user = \Auth::id();
            $model->amount        = $request->post('amount');
            $model->description   = $request->post('description') ?? '';
            $model->user_id       = $request->post('user_id');
            $model->space_id      = \Auth::user()->space_id;
            $model->balance      = 0;
            $user                 = User::find($request->post('user_id'));
            $model2               = IssuanceOfFinance::whereUserId($request->post('user_id'))->orderByDesc('id')->first();
            if ($model2){
                $model2->balance      = $user->balance ?? 0;
                $model2->save();
            }
            $model->save();

            User::transferMoney($request->post('user_id'), $request->post('amount'), User::INBOX);
        }, 10);

        return redirect()->route('issuanceOfFinance.index')->with('success', __('issuanceOfFinance.save'));
    }
}
