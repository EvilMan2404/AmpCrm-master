<?php


namespace App\Http\Controllers;


use App\Models\CarBrand;
use App\Models\Catalog;
use App\Models\Discount;
use App\Models\Files;
use App\Models\Lots;
use Carbon\Carbon;
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
use Illuminate\Validation\ValidationException;

/**
 * Class CatalogController
 * @package App\Http\Controllers
 */
class CatalogController extends Controller
{
    /**
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $search = false;
        $data   = Catalog::with(['files', 'carIdRelation'])->where(static function ($query) {
            if (\Gate::allows('policy', 'guard_catalog_view')) {
                $query->where('space_id',
                    Auth::user()->space_id);
            } else {
                $query->where('user_id',
                    Auth::id());
            }
        })->where(static function (Builder $query) use ($request) {
            /* searching by parameters */
            if ($request->get('search_for_catalog')) {
                $query->where('serial_number', 'LIKE', '%'.$request->get('search_for_catalog').'%');
            }
            if ($request->get('search_brand_id')) {
                $query->where('car_brand', '=', (int) $request->get('search_brand_id'));
            }
            /* end searching by parameters */
        });
        if ($request->get('search_for_catalog') || $request->get('search_brand_id') || $request->get('lot')) {
            $search = true;
        }

        if ($request->get('lot')) {
            if ((int) session('catalog-lot-id')) {
                if ((int) session('catalog-lot-id') !== (int) $request->get('lot')) {
                    session(['catalog-lot-id' => $request->get('lot')]);
                    $this->courseClear($request);
                }
            } else {
                session(['catalog-lot-id' => $request->get('lot')]);
                $this->courseClear($request);
            }
        }
        /*getting lot */
        $lot = new Lots();

        if ($request->get('lot')) {
            $lot = array();
            if (\Gate::allows('policy', 'guard_lots_view|guard_lots_view_self')) {
                $lot = Lots::where(static function ($query) {
                    if (\Gate::allows('policy', 'guard_lots_view')) {
                        $query->where('space_id',
                            Auth::user()->space_id);
                    } elseif (\Gate::allows('policy', 'guard_lots_view_self')) {
                        $query->where('user_id',
                            Auth::id());
                    }
                })->where('id',
                    $request->get('lot'))->with('company')->first();
            }
        }
        /*end getting lot*/

        /*getting discount*/
        $discount = Discount::where('space_id', Auth::user()->space_id)->first();
        $discount = $discount ?? new Discount();
        if ($request->get('id_catalog')) {
            $catalogInfo = Catalog::where('space_id', Auth::user()->space_id)->where('id',
                (int) $request->get('id_catalog'))->with('carIdRelation')->first();
            $search      = true;
        }
        /*end getting discount*/

        /*sorting rows*/
        $columns = ['name', 'car_brand', 'serial_number', 'pt', 'pd', 'rh', 'weight', 'id'];
        if ($request->get('sort_by') && $request->get('order')) {
            $validation_get = Validator::make($request->all(), [
                'sort_by' => [Rule::in($columns)],
                'order'   => [Rule::in(['desc', 'asc'])],
            ]);
            $sort_by        = (string) $request->get('sort_by');
            $order          = (string) $request->get('order');
            if ($validation_get->passes()) {
                if ($request->get('sort_by') === 'car_brand') {
                    $data->join('car_brand', 'catalog.car_brand', '=', 'car_brand.id')->orderBy('car_brand.name',
                        $order);
                } else {
                    $data->orderBy($sort_by, $order);
                }
                $search = true;
            } else {
                $data->orderByDesc('id');
            }
        } else {
            $data->orderByDesc('id');
        }
        /*end sorting rows*/

        /* getting brands for current catalogs*/

        $brands = CarBrand::whereSpaceId(Auth::user()->space_id)->where(static function ($query) use ($request) {
            $query->whereHas('catalogRelation', function (Builder $query) use ($request) {
                if (\Gate::allows('policy', 'guard_catalog_view')) {
                    $query->where('space_id',
                        Auth::user()->space_id);
                } else {
                    $query->where('user_id',
                        Auth::id());
                }
            });
        })->get()->toArray();
        array_unshift($brands, [
            'id'   => ' ',
            'name' => __('index.nothing')
        ]);


        /* end getting brands for current catalogs*/
        $links               = (new Helpers\HelpersController)->generateLinkForSorting($columns, $request);
        $checkCustomDiscount = (new Helpers\HelpersController)->checkCustomDiscount($request);
        return view('panel.catalogs.index', [
            'data'                => $data->paginate(15),
            'search'              => $request->get('search_for_catalog'),
            'brands'              => $brands,
            'brand_search'        => (int) $request->get('search_brand_id'),
            'catalogInfo'         => $catalogInfo ?? array(),
            'lot'                 => $lot,
            'discount'            => $discount,
            'filters'             => $search,
            'sort_by'             => $request->get('sort_by'),
            'order'               => $request->get('order'),
            'checkCustomDiscount' => $checkCustomDiscount,
            'links'               => $links,
            'breadcrumb'          => [
                'title' => __('sidebar.catalog'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('catalog.index'),
                            'name'   => __('sidebar.catalog'),
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
            $title = __('catalog.create');
            $model = new Catalog();
        } else {
            $title = __('catalog.edit');

            $model = Catalog::with('files')->where('id', $id)->first();
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$model) {
            return redirect()->route('main');
        }
        if ($id && \Gate::denies('policy', 'guard_catalog_edit|guard_catalog_edit_self,'.$model->user_id)) {
            abort(403);
        }
        return view('panel.catalogs.form', [
            'brand'      => CarBrand::whereSpaceId(Auth::user()->space_id)->get(),
            'item'       => $model,
            'success'    => Session::get('success'),
            'breadcrumb' => [
                'title' => $title,
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('catalog.index'),
                            'name'   => __('sidebar.catalog'),
                            'active' => false
                        ], [
                            'link'   => route('catalog.create'),
                            'name'   => $title,
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }

    /**
     * @param  int  $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function view(int $id, Request $request)
    {
        $data = Catalog::with(['files', 'carIdRelation'])->where('id', $id)->first();
        if ($data && $data->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (\Gate::denies('policy', 'guard_catalog_view|guard_catalog_view_self,'.$data->user_id)) {
            abort(403);
        }
        $checkCustomDiscount = (new Helpers\HelpersController)->checkCustomDiscount($request);
        return view('panel.catalogs.view', [
            'item'                => $data,
            'checkCustomDiscount' => $checkCustomDiscount,
            'breadcrumb'          => [
                'title' => $data->name,
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('catalog.index'),
                            'name'   => __('sidebar.catalog'),
                            'active' => false
                        ], [
                            'link'   => route('catalog.info', $data->id),
                            'name'   => $data->name,
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image'
        ], [
            'file.required' => __('catalog.errors.image required'),
            'file.image'    => __('catalog.errors.image bad')
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
            $file->model_type = Catalog::class;
            $file->space_id   = \Auth::user()->space_id;
            $file->file       = $f->storePublicly('catalog/'.Carbon::now()->toDateString());
            $file->save();
            return response()->json(['id' => $file->id, 'status' => true]);
        }
        return response()->json(['error' => 'Unknown'], 400);
    }

    /**
     * @param  int  $obj_id
     * @param  int  $image_id
     */
    public function removeImage(int $obj_id, int $image_id): void
    {
        $item = Files::find($image_id);
        if ($item && (int) $item->model_id === $obj_id && $item->model_type === Catalog::class) {
            try {
                $item->delete();
            } catch (\Exception $e) {
            }
        }
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request, int $id): RedirectResponse
    {
        $catalog = Catalog::with('files')->where('id', $id)->first();
        if ($catalog && $catalog->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (\Gate::denies('policy', 'guard_catalog_delete|guard_catalog_delete_self,'.$catalog->user_id)) {
            abort(403);
        }
        foreach ($catalog->files as $file) {
            $file->delete();
        }
        $catalog->delete();
        return redirect()->route('catalog.index')->with('success', __('catalog.deleted'));
    }

    /**
     * @param  Request  $request
     * @param  int|null  $id
     * @return RedirectResponse
     */
    public function save(Request $request, ?int $id = null): RedirectResponse
    {
        if ($id === null) {
            $model = new Catalog();
        } else {
            $model = Catalog::find($id);
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$model) {
            return redirect()->route('main');
        }
        if ($id && \Gate::denies('policy', 'guard_catalog_edit|guard_catalog_edit_self,'.$model->user_id)) {
            abort(403);
        } elseif (\Gate::denies('policy', 'guard_catalog_write')) {
            abort(403);
        }
        $validator = Validator::make($request->post(), [
            'name'          => 'required',
            'description'   => 'nullable',
            'serial_number' => 'required',
            'files'         => ['nullable', new \App\Rules\Files()],
            'carbrand'      => 'required|exists:car_brand,id',
            'pt'            => 'required|numeric',
            'pd'            => 'required|numeric',
            'rh'            => 'required|numeric',
            'weight'        => 'required|numeric',
        ], [
            'name.required'          => __('catalog.errors.name'),
            'serial_number.required' => __('catalog.errors.serial_number'),
            'files.required'         => __('catalog.errors.files'),
            'car_brand.required'     => __('catalog.errors.car_brand'),
            'pt.required'            => __('catalog.errors.pt'),
            'pd.required'            => __('catalog.errors.pd'),
            'rh.required'            => __('catalog.errors.rh'),
            'weight.required'        => __('catalog.errors.weight'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $model->name           = $request->post('name');
        $model->description    = $request->post('description');
        $model->serial_number  = $request->post('serial_number');
        $model->car_brand      = $request->post('carbrand');
        $model->pt             = $request->post('pt');
        $model->pd             = $request->post('pd');
        $model->rh             = $request->post('rh');
        $model->space_id       = \Auth::user()->space_id;
        $model->weight         = $request->post('weight');
        $model->user_id_edited = Auth::id();
        $files                 = explode(',', $request->post('files'));
        if (!$id) {
            $model->user_id = Auth::id();
        }
        $model->save();
        //  dd($files);
        foreach ($files as $file) {
            $item = Files::find($file);
            if ($item) {
                $item->model_id = $model->id;
                $item->save();
            }
        }
        return redirect()->route('catalog.edit', ['id' => $model->id])->with('success', __('catalog.save'));
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function courseSave(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'pt'   => 'required|numeric|min:0',
            'pd'   => 'required|numeric|min:0',
            'rh'   => 'required|numeric|min:0',
            'd_pt' => 'required|numeric|min:0',
            'd_pd' => 'required|numeric|min:0',
            'd_rh' => 'required|numeric|min:0',
        ], [
            'required' => __('catalog.course_settings.errors.required'),
            'numeric'  => __('catalog.course_settings.errors.numeric'),
            'min'      => __('catalog.course_settings.errors.min'),
        ]);
        $pt   = $request->post('pt'); //курс pt
        $pd   = $request->post('pd'); //курс pd
        $rh   = $request->post('rh'); //курс rh
        $d_pt = $request->post('d_pt'); //скидка pt
        $d_pd = $request->post('d_pd'); //скидка pd
        $d_rh = $request->post('d_rh'); //скидка rh
        session([
            'pt'   => $pt,
            'pd'   => $pd,
            'rh'   => $rh,
            'd_pt' => $d_pt,
            'd_pd' => $d_pd,
            'd_rh' => $d_rh,
        ]);
        $request->session()->forget(['catalog-lot-id']);
        return redirect(route('catalog.index'))->with('success', __('catalog.course_settings.saved'));
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function courseClear(Request $request): RedirectResponse
    {
        $request->session()->forget(['pt', 'pd', 'rh', 'd_pt', 'd_pd', 'd_rh']);
        return redirect()->back()->with('success', __('catalog.course_settings.cleared'));
    }
}
