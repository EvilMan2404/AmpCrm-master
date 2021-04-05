<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\Task;
use App\Models\TasksPriorities;
use App\Models\TasksStatuses;
use App\Models\User;
use App\Rules\CheckSource;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TaskController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $data = Task::with([])->where(static function ($query) {
            if (\Gate::allows('policy', 'guard_tasks_view')) {
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
        });

        /*sorting rows*/
        if ($request->get('sort_by') && $request->get('order')) {
            $validation_get = Validator::make($request->all(), [
                'sort_by' => [Rule::in(['id'])],
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

        $path = (new Helpers\HelpersController)->array2string($request->all()); // formatting url
        return view('panel.tasks.index', [
            'data'       => $data->paginate(15),
            'path'       => $path,
            'searchName' => $request->get('name'),
            'breadcrumb' => [
                'title' => __('sidebar.tasks'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('tasks.index'),
                            'name'   => __('sidebar.tasks'),
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }

    /**
     * @param  int|null  $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function form(?int $id = null)
    {
        if ($id === null) {
            $title = __('tasks.create');
            $model = new Task();
        } else {
            $title = __('tasks.edit');

            $model = Task::where('id', $id)->first();
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$model) {
            return redirect()->route('main');
        }

        if ($id && \Gate::denies('policy', 'guard_tasks_edit|guard_tasks_edit_self,'.$model->user_id)) {
            abort(403);
        }

        $assigned_user_id = old('assigned_user', $model->assigned_user);
        $assignedUserInfo = User::where('id', $assigned_user_id)->first();

        if (old('source', $model->source)) {
            $modelTypeList = array_keys(Task::MODEL_TYPE_LIST);
            if (in_array(old('source', $model->source), $modelTypeList, true)) {
                $source_id  = old('source_id', $model->source_id);
                $sourceInfo = old('source', $model->source)::where('id', $source_id)->first();
            }
        }

        $modelTypeList = Task::MODEL_TYPE_LIST;


        $statuses   = TasksStatuses::whereSpaceId(Auth::user()->space_id)->get();
        $priorities = TasksPriorities::whereSpaceId(Auth::user()->space_id)->get();
        return view('panel.tasks.form', [
            'item'             => $model,
            'assignedUserInfo' => $assignedUserInfo,
            'statuses'         => $statuses,
            'priorities'       => $priorities,
            'sourceInfo'       => $sourceInfo ?? array(),
            'modelTypeList'    => $modelTypeList,
            'breadcrumb'       => [
                'title' => $title,
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('users.index'),
                            'name'   => __('sidebar.users'),
                            'active' => true
                        ], [
                            'link'   => route('users.create'),
                            'name'   => __('users.create'),
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
     * @throws ValidationException
     */
    public function save(Request $request, ?int $id = null): RedirectResponse
    {
        $this->validateFields($request, $id);
        if ($id === null) {
            $model = new Task();
        } else {
            $model = Task::find($id);
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$model) {
            return redirect()->route('main');
        }
        if ($id && \Gate::denies('policy', 'guard_tasks_edit|guard_tasks_edit_self,'.$model->user_id)) {
            abort(403);
        } elseif (\Gate::denies('policy', 'guard_tasks_add')) {
            abort(403);
        }
        $model->name          = $request->post('name');
        $model->description   = $request->post('description');
        $model->status_id     = $request->post('status_id');
        $model->date_start    = $request->post('date_start');
        $model->date_end      = $request->post('date_end');
        $model->source        = $request->post('source');
        $model->source_id     = $request->post('source_id');
        $model->priority_id   = $request->post('priority_id');
        $model->assigned_user = $request->post('assigned_user');
        if (!$id) {
            $model->space_id = Auth::user()->space_id;
            $model->user_id  = Auth::id();
        }
        $model->save();
        $files = explode(',', $request->post('files'));
        foreach ($files as $file) {
            $item = Files::find($file);
            if ($item) {
                $item->model_id = $model->id;
                $item->save();
            }
        }
        return redirect()->route('tasks.index')->with('success', __('tasks.save'));
    }

    /**
     * @param  int  $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function view(int $id)
    {
        $data = Task::with([])->where('id',
            $id)->first();
        if ($data && $data->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$data) {
            return redirect()->route('main');
        }

        if (\Gate::denies('policy', 'guard_tasks_view|guard_tasks_view_self,'.$data->user_id)) {
            abort(403);
        }

        $modelSourceList = Task::MODEL_TYPE_LIST;
        $source          = $modelSourceList[$data->source];
        $sourceInfo      = $data->source::find($data->source_id);
        return view('panel.tasks.view', [
            'item'       => $data,
            'source'     => $source,
            'sourceInfo' => $sourceInfo,
            'breadcrumb' => [
                'title' => __('tasks.view'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('users.index'),
                            'name'   => __('sidebar.tasks'),
                            'active' => false
                        ], [
                            'link'   => route('tasks.info', $data->id),
                            'name'   => $data->name,
                            'active' => true
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
        $model = Task::where('id', $id)->first();
        if ($model && $model->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$model) {
            return redirect()->route('main');
        }
        if (\Gate::denies('policy', 'guard_tasks_delete|guard_tasks_delete_self,'.$model->user_id)) {
            abort(403);
        }
        foreach ($model->files as $file) {
            $file->delete();
        }

        $model->delete();
        return redirect()->route('tasks.index')->with('success', __('tasks.deleted'));
    }

    /**
     * @param $request
     * @param $id
     * @throws ValidationException
     */
    public function validateFields($request, $id): void
    {
        $messages = [
            'required'    => __('tasks.errors.required'),
            'exists'      => __('tasks.errors.exists'),
            'date_format' => __('tasks.errors.date_format'),
        ];
        if ($id === null) {
            $this->validate($request, [
                'name'          => 'required',
                'files'         => ['nullable', new \App\Rules\Files()],
                'status_id'     => 'required|exists:tasks_statuses,id',
                'date_start'    => 'required|date_format:Y-m-d\TH:i',
                'date_end'      => 'required|date_format:Y-m-d\TH:i',
                'source'        => ['required', new CheckSource()],
                $this->sourceIdRule($request),
                'priority_id'   => 'required|exists:tasks_priorities,id',
                'assigned_user' => 'required|exists:users,id',
            ],
                $messages
            );
        } else {
            $this->validate($request, [
                'name'          => 'required',
                'files'         => ['nullable', new \App\Rules\Files()],
                'status_id'     => 'required|exists:tasks_statuses,id',
                'date_start'    => 'required|date_format:Y-m-d\TH:i',
                'date_end'      => 'required|date_format:Y-m-d\TH:i',
                'source'        => ['required', new CheckSource()],
                $this->sourceIdRule($request),
                'priority_id'   => 'required|exists:tasks_priorities,id',
                'assigned_user' => 'required|exists:users,id',
            ],
                $messages
            );
        }
    }

    /**
     * @return string[]
     */
    public function sourceIdRule($request): array
    {
        $messageableIdRule = 'required_with:source';
        if ($request->has('source')) {
            $messageableIdRule .= '|model_exists:'.$request->source.',id';
        }
        return [
            'source_id' => $messageableIdRule,
        ];
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,jpg,png,gif,docx,doc'
        ], [
            'required' => __('tasks.errors.mimes'),
            'mimes'    => __('tasks.errors.mimes'),
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'status' => false]);
        }
        $f = $request->file('file');
        if ($f) {
            $file             = new Files();
            $file->name       = $f->getClientOriginalName();
            $file->ext        = $f->getClientOriginalExtension();
            $file->size       = $f->getSize();
            $file->model_type = Task::class;
            $file->space_id   = \Auth::user()->space_id;
            $file->file       = $f->storePublicly('task/'.Carbon::now()->toDateString());
            $file->save();
            return response()->json(['id' => $file->id, 'status' => true]);
        }
        return response()->json(['error' => 'Unknown'], 400);
    }

    /**
     * @param  int  $obj_id
     * @param  int  $image_id
     */
    public function removeFile(int $obj_id, int $image_id): void
    {
        $item = Files::find($image_id);
        if ($item && (int) $item->model_id === $obj_id && $item->model_type === Task::class) {
            try {
                $item->delete();
            } catch (\Exception $e) {
            }
        }
    }

    /**
     * @param $filename
     * @return BinaryFileResponse
     */
    public function getFile(Request $request)
    {
        $this->validate($request, [
            'filename' => 'required'
        ]);
        $filename = $request->post('filename');
        $folder   = 'app/';
        $file     = Storage::disk('public')->url($folder.$filename);
        if (is_file(storage_path("{$folder}{$filename}"))) {
            return response()->download(storage_path("{$folder}{$filename}"));
        }

        return redirect()->back();
    }
}
