<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\SpaceHasRole;
use App\Models\Spaces;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class SpaceController extends Controller
{
    /**
     * @param  Request  $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Request $request)
    {
        $data = Spaces::with([]);
        if ($request->get('name')) {
            $data->where('title', 'LIKE', '%'.$request->get('name').'%');
        }
        /*sorting rows*/
        if ($request->get('sort_by') && $request->get('order')) {
            $validation_get = Validator::make($request->all(), [
                'sort_by' => [Rule::in(['title', 'id',])],
                'order'   => [Rule::in(['desc', 'asc'])],
            ]);
            $sort_by        = (string) $request->get('sort_by');
            $order          = (string) $request->get('order');
            if ($validation_get->passes()) {
                $data->orderBy($sort_by, $order);
            } else {
                $data->orderByDesc('id');
            }
        } else {
            $data->orderByDesc('id');
        }
        /*end sorting rows*/
        $id = $request->get('edit');
        if ($id === null) {
            $model = new Spaces();
        } else {
            $model = Spaces::where('id', $id)->first();
        }
        if (!$model) {
            return redirect()->route('main');
        }

        $role_id = count($model->hasRoles) > 0 ? $model->hasRoles : array();
        $roles   = array();
        foreach ($role_id as $role) {
            $roles[] = $role->role_id;
        }
        $roleInfo = Roles::whereIn('id', $roles)->get();
        $path     = (new Helpers\HelpersController)->array2string($request->all()); // formatting url
        return view('panel.space.index', [
            'data'       => $data->paginate(15),
            'item'       => $model,
            'path'       => $path,
            'rolesInfo'  => $roleInfo,
            'searchName' => $request->get('name'),
            'breadcrumb' => [
                'title' => __('sidebar.spaces'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('space.index'),
                            'name'   => __('sidebar.spaces'),
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
     */
    public function save(Request $request, ?int $id = null): RedirectResponse
    {
        $validator = Validator::make($request->post(), [
            'title'   => 'required',
            'roles'   => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ], [
            'title.required' => __('space.errors.name'),
            'roles.required' => __('space.errors.roles'),
            'exists'         => __('space.errors.exists'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($id === null) {
            $model = new Spaces();
        } else {
            $model = Spaces::find($id);
        }
        \DB::transaction(static function () use ($model, $request) {
            $model->title = $request->post('title');
            $model->save();
            SpaceHasRole::where('space_id', $model->id)->delete();
            foreach ($request->post('roles') as $role) {
                $addRelation           = new SpaceHasRole();
                $addRelation->role_id  = $role;
                $addRelation->space_id = $model->id;
                $addRelation->save();
            }
        });

        return redirect()->route('space.index')->with('success', __('space.save'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete($id): RedirectResponse
    {
        $model = Spaces::where('id', $id)->first();
        if (!$model) {
            return redirect()->route('space.index');
        }
        $model->delete();
        return redirect()->route('space.index')->with('success', __('space.deleted'));
    }
}
