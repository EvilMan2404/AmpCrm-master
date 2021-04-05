<?php

namespace App\Http\Controllers;

use App\Models\TasksStatuses;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class TasksStatusesController extends Controller
{
    /**
     * @param  Request  $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Request $request)
    {
        $data = TasksStatuses::whereSpaceId(Auth::id())->where(static function (Builder $query) use ($request) {
            if ($request->get('name')) {
                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
            }
            if ($request->get('sort_by') && $request->get('order')) {
                $validation_get = Validator::make($request->all(), [
                    'sort_by' => [Rule::in(['name', 'id',])],
                    'order'   => [Rule::in(['desc', 'asc'])],
                ]);
                $sort_by        = (string) $request->get('sort_by');
                $order          = (string) $request->get('order');
                if ($validation_get->passes()) {
                    $query->orderBy($sort_by, $order);
                } else {
                    $query->orderByDesc('id');
                }
            } else {
                $query->orderByDesc('id');
            }
        })->paginate(15);


        $id = $request->get('edit');
        if ($id === null) {
            $model = new TasksStatuses();
        } else {
            $model = TasksStatuses::where('id', $id)->first();
            if ($model && $model->space_id !== Auth::user()->space_id) {
                return redirect()->route('taskStatus.index');
            }
        }
        if (!$model) {
            return redirect()->route('taskStatus.index');
        }


        $path = ($request->get('name')) ? (new Helpers\HelpersController)->array2string(['name' => $request->get('name')]) : ''; // formatting url
        return view('panel.taskStatus.index', [
            'data'       => $data,
            'item'       => $model,
            'path'       => $path,
            'searchName' => $request->get('name'),
            'breadcrumb' => [
                'title' => __('sidebar.taskStatus'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('taskStatus.index'),
                            'name'   => __('sidebar.taskStatus'),
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
            'name' => 'required',
        ], [
            'name.required' => __('taskStatus.errors.name'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($id === null) {
            $model = new TasksStatuses();
        } else {
            $model = TasksStatuses::find($id);
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('taskStatus.index');
            }
        }
        \DB::transaction(static function () use ($model, $request, $id) {
            $model->name = $request->post('name');
            if (!$id) {
                $model->space_id = \Auth::id();
            }

            $model->save();
        });

        return redirect()->route('taskStatus.index')->with('success', __('taskStatus.save'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete($id): RedirectResponse
    {
        $model = TasksStatuses::where('id', $id)->first();
        if ($model && $model->space_id !== \Auth::user()->space_id) {
            return redirect()->route('taskStatus.index');
        }
        if (!$model) {
            return redirect()->route('taskStatus.index');
        }
        $model->delete();
        return redirect()->route('taskStatus.index')->with('success', __('taskStatus.deleted'));
    }
}
