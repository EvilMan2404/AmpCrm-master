<?php

namespace App\Http\Controllers;

use App\Models\TasksPriorities;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TasksPrioritiesController extends Controller
{
    /**
     * @param  Request  $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Request $request)
    {
        $data = TasksPriorities::whereSpaceId(Auth::id());
        if ($request->get('name')) {
            $data->where('name', 'LIKE', '%'.$request->get('name').'%');
        }
        /*sorting rows*/
        if ($request->get('sort_by') && $request->get('order')) {
            $validation_get = Validator::make($request->all(), [
                'sort_by' => [Rule::in(['name', 'id',])],
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
            $model = new TasksPriorities();
        } else {
            $model = TasksPriorities::where('id', $id)->first();
            if ($model && $model->space_id !== Auth::user()->space_id) {
                return redirect()->route('taskPriority.index');
            }
        }
        if (!$model) {
            return redirect()->route('taskPriority.index');
        }


        $path = ($request->get('name')) ? (new Helpers\HelpersController)->array2string(['name' => $request->get('name')]) : ''; // formatting url
        return view('panel.taskPriority.index', [
            'data'       => $data->paginate(15),
            'item'       => $model,
            'path'       => $path,
            'searchName' => $request->get('name'),
            'breadcrumb' => [
                'title' => __('sidebar.taskPriority'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('taskPriority.index'),
                            'name'   => __('sidebar.taskPriority'),
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
            'name'             => 'required',
            'text_color'       => 'required',
            'background_color' => 'required',
        ], [
            'required' => __('taskPriority.errors.name'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($id === null) {
            $model = new TasksPriorities();
        } else {
            $model = TasksPriorities::find($id);
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('taskPriority.index');
            }
        }
        \DB::transaction(static function () use ($model, $request, $id) {
            $model->name             = $request->post('name');
            $model->text_color       = $request->post('text_color');
            $model->background_color = $request->post('background_color');
            if (!$id) {
                $model->space_id = \Auth::id();
            }

            $model->save();
        });

        return redirect()->route('taskPriority.index')->with('success', __('taskPriority.save'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete($id): RedirectResponse
    {
        $model = TasksPriorities::where('id', $id)->first();
        if ($model && $model->space_id !== \Auth::user()->space_id) {
            return redirect()->route('taskPriority.index');
        }
        if (!$model) {
            return redirect()->route('taskPriority.index');
        }
        $model->delete();
        return redirect()->route('taskPriority.index')->with('success', __('taskPriority.deleted'));
    }
}
