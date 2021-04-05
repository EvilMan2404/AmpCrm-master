<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Company;
use App\Models\Country;
use App\Models\Files;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class CompanyController
 * @package App\Http\Controllers
 */
class CompanyController extends Controller
{
    /**
     * @param  Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $filters = false;
        $data    = Company::with([
            'files', 'userEdited', 'countriesRelation', 'citiesRelation'
        ])->where(static function ($query) {
            if (\Gate::allows('policy', 'guard_company_view')) {
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
            if ($request->get('phone')) {
                $query->where('phone', 'LIKE', '%'.$request->get('phone').'%');
            }
            if ($request->get('email')) {
                $query->where('email', 'LIKE', '%'.$request->get('email').'%');
            }
            if ($request->get('website')) {
                $query->where('website', 'LIKE', '%'.$request->get('website').'%');
            }
            if ($request->get('billing_address')) {
                $query->where('billing_address', 'LIKE', '%'.$request->get('billing_address').'%');
            }
        });
        if ($request->get('name') || $request->get('phone') || $request->get('email') || $request->get('website') || $request->get('billing_address')) {
            $filters = true;
        }
        /*sorting rows*/
        $columns = ['id', 'updated_at', 'email', 'name', 'phone', 'website'];
        if ($request->get('sort_by') && $request->get('order')) {
            $validation_get = Validator::make($request->all(), [
                'sort_by' => [Rule::in($columns)],
                'order'   => [Rule::in(['desc', 'asc'])],
            ]);
            $sort_by        = (string) $request->get('sort_by');
            $order          = (string) $request->get('order');
            if ($validation_get->passes()) {
                $data->orderBy($sort_by, $order);
                $filters = true;
            } else {
                $data->orderByDesc('id');
            }
        } else {
            $data->orderByDesc('id');
        }
        /*end sorting rows*/
        $links = (new Helpers\HelpersController)->generateLinkForSorting($columns, $request);
        $path  = (new Helpers\HelpersController)->array2string($request->all()); // formatting url
        return view('panel.companies.index', [
            'data'          => $data->paginate(15),
            'path'          => $path,
            'filters'       => $filters,
            'links'         => $links,
            'sort_by'       => $request->get('sort_by'),
            'order'         => $request->get('order'),
            'searchName'    => (string) $request->get('name'),
            'searchPhone'   => (string) $request->get('phone'),
            'searchEmail'   => (string) $request->get('email'),
            'searchSite'    => (string) $request->get('website'),
            'searchBilling' => (string) $request->get('billing_address'),
            'breadcrumb'    => [
                'title' => __('sidebar.companyFixPrice'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('company.index'),
                            'name'   => __('sidebar.companyFixPrice'),
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function view(int $id)
    {
        $data = Company::with(['files', 'userEdited', 'countriesRelation', 'citiesRelation'])->where('id',
            $id)->first();
        if ($data && $data->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$data) {
            return redirect()->route('main');
        }
        if (\Gate::denies('policy', 'guard_company_view|guard_company_view_self,'.$data->user_id)) {
            abort(403);
        }
        return view('panel.companies.view', [
            'item'       => $data,
            'breadcrumb' => [
                'title' => $data->name,
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('company.index'),
                            'name'   => __('sidebar.companyFixPrice'),
                            'active' => false
                        ], [
                            'link'   => route('company.info', $data->id),
                            'name'   => $data->name,
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }

    /**
     * @param  int|null  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function form(?int $id = null)
    {
        $country = Country::all();
        if ($id === null) {
            $title = __('company.create');
            $model = new Catalog();
        } else {
            $title = __('company.edit');

            $model = Company::with('files')->where('id', $id)->first();
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$model) {
            return redirect()->route('main');
        }
        if ($id && \Gate::denies('policy', 'guard_company_edit|guard_company_edit_self,'.$model->user_id)) {
            abort(403);
        }
        return view('panel.companies.form', [
            'item'       => $model,
            'breadcrumb' => [
                'title' => $title,
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('company.index'),
                            'name'   => __('sidebar.companyFixPrice'),
                            'active' => true
                        ], [
                            'link'   => route('company.create'),
                            'name'   => __('company.create'),
                            'active' => true
                        ],
                    ]
            ],
            'country'    => $country,
        ]);
    }

    /**
     * @param  Request  $request
     * @param  int|null  $id
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(Request $request, ?int $id = null): RedirectResponse
    {
        $this->validateFields($request, $id);
        if ($id === null) {
            $company = new Company();
        } else {
            $company = Company::find($id);
            if ($company && $company->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$company) {
            return redirect()->route('main');
        }
        if ($id && \Gate::denies('policy', 'guard_company_edit|guard_company_edit_self,'.$company->user_id)) {
            abort(403);
        } elseif (\Gate::denies('policy', 'guard_company_add')) {
            abort(403);
        }
        $f = $request->file('logo');
        if ($id !== null && $f) {
            if ($company->files) {
                $company->files->delete();
            }
        }
        $website                              = str_replace(array('http://', 'https://'), '',
            $request->post('website'));
        $company->name                        = $request->post('name');
        $company->description                 = $request->post('description');
        $company->website                     = $website;
        $company->email                       = $request->post('email');
        $company->phone                       = $request->post('phone');
        $company->billing_address_country     = $request->post('billing_address_country');
        $company->billing_address_state       = $request->post('billing_address_state');
        $company->billing_address_city        = $request->post('billing_address_city');
        $company->billing_address_street      = $request->post('billing_address_street');
        $company->billing_address_postal_code = $request->post('billing_address_postal_code');
        $company->billing_address             = $request->post('billing_address');
        $company->shipping_address            = $request->post('shipping_address');
        $company->payment_info                = $request->post('payment_info');
        $company->last_user_id                = Auth::id();
        if (!$id) {
            $company->user_id = Auth::id();
        }
        $company->space_id = Auth::user()->space_id;
        $company->save();
        if ($f) {
            $file             = new Files();
            $file->name       = $f->getClientOriginalName();
            $file->ext        = $f->getClientOriginalExtension();
            $file->size       = $f->getSize();
            $file->model_type = 'App\Models\Company';
            $file->model_id   = $company->id;
            $file->space_id   = Auth::user()->space_id;
            $file->file       = $f->storePublicly('company');
            $file->save();
        }
        return redirect()->route('company.index')->with('success', __('company.save'));
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request, int $id): RedirectResponse
    {
        $company = Company::with('files')->where('id', $id)->first();
        if ($company && $company->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$company) {
            return redirect()->route('main');
        }
        if (\Gate::denies('policy', 'guard_company_delete|guard_company_delete_self,'.$company->user_id)) {
            abort(403);
        }
        if ($company->files) {
            $company->files->delete();
        }

        $company->delete();
        return redirect()->route('company.index')->with('success', __('company.deleted'));
    }

    /**
     * @param $request
     * @param $id
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateFields($request, $id): void
    {
        $messages = [
            'name.required'                        => __('company.errors.name'),
            'name.min'                             => __('company.errors.name'),
            'name.max'                             => __('company.errors.name'),
            'logo.required'                        => __('company.errors.logo'),
            'logo.image'                           => __('company.errors.logo'),
            'logo.mimes'                           => __('company.errors.logo'),
            'logo.max'                             => __('company.errors.logo'),
            'website.required'                     => __('company.errors.website'),
            'phone.required'                       => __('company.errors.phone'),
            'billing_address_country.required'     => __('company.errors.billing_address_country'),
            'billing_address_country.numeric'      => __('company.errors.billing_address_country'),
            'billing_address_country.exists'       => __('company.errors.billing_address_country'),
            'billing_address_state.required'       => __('company.errors.billing_address_state'),
            'billing_address_street.required'      => __('company.errors.billing_address_street'),
            'billing_address_city.required'        => __('company.errors.billing_address_city'),
            'billing_address_city.numeric'         => __('company.errors.billing_address_city'),
            'billing_address_city.exists'          => __('company.errors.billing_address_city'),
            'billing_address_postal_code.required' => __('company.errors.billing_address_postal_code'),
            'billing_address.required'             => __('company.errors.billing_address'),
            'shipping_address.required'            => __('company.errors.shipping_address'),
            'payment_info.required'                => __('company.errors.payment_info'),
        ];
        if ($id === null) {
            $this->validate($request, [
                'name'                        => 'required|min:3|max:200',
                'logo'                        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'website'                     => 'nullable',
                'email'                       => 'nullable|email:rfc,dns',
                'phone'                       => 'required',
                'billing_address_country'     => 'required|numeric|exists:country,id',
                'billing_address_state'       => 'nullable',
                'billing_address_city'        => 'nullable|numeric|exists:city,id',
                'billing_address_street'      => 'nullable',
                'billing_address_postal_code' => 'nullable|numeric',
                'billing_address'             => 'nullable',
                'shipping_address'            => 'nullable',
                'payment_info'                => 'nullable',
            ], $messages);
        } else {
            $this->validate($request, [
                'name'                        => 'required|min:3|max:250',
                'logo'                        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'website'                     => 'nullable',
                'email'                       => 'nullable|email:rfc,dns',
                'phone'                       => 'required',
                'billing_address_country'     => 'required|numeric|exists:country,id',
                'billing_address_state'       => 'nullable',
                'billing_address_city'        => 'nullable|numeric|exists:city,id',
                'billing_address_street'      => 'nullable',
                'billing_address_postal_code' => 'nullable|numeric',
                'billing_address'             => 'nullable',
                'shipping_address'            => 'nullable',
                'payment_info'                => 'nullable',
            ], $messages);
        }
    }
}
