<?php

namespace App\Http\Controllers;

use App\Models\Permissions;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PermissionsController extends Controller
{
    /**
     * @param  Request  $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Request $request)
    {
        $search = false;
        $data   = Permissions::where(static function ($query) use ($request) {
            if ($request->get('name')) {
                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
            }
        });
        if ($request->get('name')) {
            $search = true;
        }
        /*sorting rows*/
        $columns = ['name', 'id','guard_name'];
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
        $id = $request->get('edit');
        if ($id === null) {
            $model = new Permissions();
        } else {
            $model = Permissions::where('id', $id)->first();
        }
        if (!$model) {
            return redirect()->route('permissions.index');
        }

        $links = (new Helpers\HelpersController)->generateLinkForSorting($columns, $request);
        $path  = ($request->get('name')) ? (new Helpers\HelpersController)->array2string(['name' => $request->get('name')]) : ''; // formatting url
        return view('panel.permissions.index', [
            'data'       => $data->paginate(15),
            'item'       => $model,
            'filters'     => $search,
            'path'       => $path,
            'links'      => $links,
            'sort_by'    => $request->get('sort_by'),
            'order'      => $request->get('order'),
            'searchName' => $request->get('name'),
            'breadcrumb' => [
                'title' => __('sidebar.permissions'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('permissions.index'),
                            'name'   => __('sidebar.permissions'),
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
     * @throws Throwable
     * @throws \Throwable
     */
    public function save(Request $request, ?int $id = null): RedirectResponse
    {
        $validator = Validator::make($request->post(), [
            'name'       => 'required',
            'desc'       => 'required',
            'guard_name' => 'required',
        ], [
            'required' => __('permissions.errors.required'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($id === null) {
            $model = new Permissions();
        } else {
            $model = Permissions::find($id);
        }
        if (!$model) {
            return redirect(route('main'));
        }
        \DB::transaction(static function () use ($model, $request, $id) {
            $model->name       = $request->post('name');
            $model->desc       = $request->post('desc');
            $model->guard_name = $request->post('guard_name');
            $model->save();
        });

        return redirect()->route('permissions.index')->with('success', __('permissions.save'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @throws Exception
     * @throws Exception
     */
    public function delete($id): RedirectResponse
    {
        $model = Permissions::where('id', $id)->first();
        if (!$model) {
            return redirect()->route('permissions.index');
        }
        $model->delete();
        return redirect()->route('permissions.index')->with('success', __('permissions.deleted'));
    }
}
