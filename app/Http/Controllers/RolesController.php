<?php

namespace App\Http\Controllers;

use App\Models\Permissions;
use App\Models\RoleHasPermissions;
use App\Models\Roles;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{
    /**
     * @param  Request  $request
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = false;
        $data   = Roles::where(static function ($query) use ($request) {
            if ($request->get('name')) {
                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
            }
        });
        if ($request->get('name')) {
            $search = true;
        }

        /*sorting rows*/
        $columns = [
            'id', 'name', 'guard_name'
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
        $path  = (new Helpers\HelpersController)->array2string($request->all()); // formatting url
        $links = (new Helpers\HelpersController)->generateLinkForSorting($columns, $request);
        return view('panel.roles.index', [
            'data'       => $data->paginate(15),
            'path'       => $path,
            'links'      => $links,
            'searchName' => $request->get('name'),
            'sort_by'    => $request->get('sort_by'),
            'order'      => $request->get('order'),
            'breadcrumb' => [
                'title' => __('sidebar.roles'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('roles.index'),
                            'name'   => __('sidebar.roles'),
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
        $data = Roles::where('id',
            $id)->first();
        if (!$data) {
            return redirect()->route('main');
        }
        return view('panel.roles.view', [
            'item'       => $data,
            'breadcrumb' => [
                'title' => __('roles.view'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('roles.index'),
                            'name'   => __('sidebar.roles'),
                            'active' => false
                        ], [
                            'link'   => route('roles.info', $data->id),
                            'name'   => $data->name,
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }

    /**
     * @param  int|null  $id
     * @return Application|Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function form(?int $id = null)
    {
        if ($id === null) {
            $title = __('roles.create');
            $model = new Roles();
        } else {
            $title = __('roles.edit');

            $model = Roles::where('id', $id)->first();
        }
        if (!$model) {
            return redirect()->route('main');
        }
        $rolePermissions = $model->arrayPermissions();
        $permissions     = Permissions::all();
        return view('panel.roles.form', [
            'item'            => $model,
            'permissions'     => $permissions,
            'rolePermissions' => $rolePermissions,
            'breadcrumb'      => [
                'title' => $title,
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('roles.index'),
                            'name'   => __('sidebar.roles'),
                            'active' => false
                        ], [
                            'link'   => route('roles.create'),
                            'name'   => __('roles.create'),
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
     * @throws \Throwable
     */
    public function save(Request $request, ?int $id = null): RedirectResponse
    {
        $this->validateFields($request);
        if ($id === null) {
            $role = new Roles();
        } else {
            $role = Roles::find($id);
        }
        if (!$role) {
            return redirect()->route('main');
        }
        DB::transaction(static function () use ($role, $request) {
            $role->name       = $request->post('name');
            $role->guard_name = $request->post('guard_name');
            $role->save();
            RoleHasPermissions::where('role_id', $role->id)->delete();
            foreach ($request->post('permissions') as $permission) {
                $addRelation                = new RoleHasPermissions();
                $addRelation->role_id       = $role->id;
                $addRelation->permission_id = $permission;
                $addRelation->save();
            }
        });
        return redirect()->route('roles.edit', ['id' => $role->id])->with('success', __('roles.save'));
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request, int $id): RedirectResponse
    {
        $role = Roles::where('id', $id)->first();
        if (!$role) {
            return redirect()->route('main');
        }
        if (count($role->hasUsers)) {
            return redirect()->route('roles.index')->with('error', __('roles.cant_delete'));
        }
        foreach ($role->permissions as $item) {
            $item->delete();
        }
        $role->delete();
        return redirect()->route('roles.index')->with('success', __('roles.deleted'));
    }

    /**
     * @param $request
     * @param $id
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateFields($request)
    {
        $messages = [
            'required'             => __('roles.errors.required'),
            'permissions.required' => __('roles.errors.p_required'),
            'exists'               => __('roles.errors.exists'),
        ];

        $this->validate($request, [
            'name'          => 'required',
            'guard_name'    => 'required',
            'permissions'   => 'required',
            'permissions.*' => 'exists:permissions,id',
        ],
            $messages
        );
    }

}
