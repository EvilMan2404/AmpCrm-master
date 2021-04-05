<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    /**
     * @param  Request  $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Request $request)
    {
        $data = CarBrand::whereSpaceId(\Auth::id());
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
            $model = new CarBrand();
        } else {
            $model = CarBrand::where('id', $id)->first();
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('brand.index');
            }
        }
        if (!$model) {
            return redirect()->route('brand.index');
        }


        $path = ($request->get('name')) ? (new Helpers\HelpersController)->array2string(['name' => $request->get('name')]) : ''; // formatting url
        return view('panel.brand.index', [
            'data'       => $data->paginate(15),
            'item'       => $model,
            'path'       => $path,
            'searchName' => $request->get('name'),
            'breadcrumb' => [
                'title' => __('sidebar.brand'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('brand.index'),
                            'name'   => __('sidebar.brand'),
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
            'name.required' => __('brand.errors.name'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($id === null) {
            $model = new CarBrand();
        } else {
            $model = CarBrand::find($id);
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('brand.index');
            }
        }
        \DB::transaction(static function () use ($model, $request, $id) {
            $model->name = $request->post('name');
            if (!$id) {
                $model->space_id = \Auth::id();
            }

            $model->save();
        });

        return redirect()->route('brand.index')->with('success', __('brand.save'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete($id): RedirectResponse
    {
        $model = CarBrand::where('id', $id)->first();
        if ($model && $model->space_id !== \Auth::user()->space_id) {
            return redirect()->route('brand.index');
        }
        if (!$model) {
            return redirect()->route('brand.index');
        }
        $model->delete();
        return redirect()->route('brand.index')->with('success', __('brand.deleted'));
    }
}
