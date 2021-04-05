<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\ClientGroupType;
use App\Models\Clients;
use App\Models\ClientType;
use App\Models\Country;
use App\Models\Files;
use App\Models\Industry;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = false;
        $data   = Clients::with([
            'files', 'clientTypeRelation', 'clientIndustry', 'countriesShippingRelation', 'countriesBillingRelation',
            'citiesBilling', 'citiesShipping', 'clientGroupTypeRelation'
        ])->where(static function ($query) {
            if (\Gate::allows('policy', 'guard_clients_view')) {
                $query->where('space_id',
                    Auth::user()->space_id);
            } else {
                $query->where('assigned_user_id',
                    Auth::id());
            }
        })->where(static function ($query) use ($request) {
            if ($request->get('name')) {
                $query->where(static function ($query) use ($request) {
                    $name = explode(' ', $request->get('name'));
                    $query->where(static function (Builder $query) use ($name) {
                        foreach ($name as $key => $item) {
                            if ($key === 0) {
                                $query->where('name', 'like', '%'.$item.'%');
                            } else {
                                $query->orWhere('name', 'like', '%'.$item.'%');
                            }
                        }
                    })->orWhere(static function (Builder $query) use ($name) {
                        foreach ($name as $key => $item) {
                            if ($key === 0) {
                                $query->where('second_name', 'like', '%'.$item.'%');
                            } else {
                                $query->orWhere('second_name', 'like', '%'.$item.'%');
                            }
                        }
                    })->orWhere(static function (Builder $query) use ($name) {
                        foreach ($name as $key => $item) {
                            if ($key === 0) {
                                $query->where('third_name', 'like', '%'.$item.'%');
                            } else {
                                $query->orWhere('third_name', 'like', '%'.$item.'%');
                            }
                        }
                    });
                });
            }
            if ($request->get('phone')) {
                $query->where('phone', 'LIKE', '%'.$request->get('phone').'%');
            }
        });
        if ($request->get('name') || $request->get('phone')) {
            $search = true;
        }

        /*sorting rows*/
        if ($request->get('sort_by') && $request->get('order')) {
            $validation_get = Validator::make($request->all(), [
                'sort_by' => [Rule::in(['fullname', 'id'])],
                'order'   => [Rule::in(['desc', 'asc'])],
            ]);
            $sort_by        = (string) $request->get('sort_by');
            $order          = (string) $request->get('order');
            if ($validation_get->passes()) {
                if ($request->get('sort_by') === 'fullname') {
                    $data->orderBy('name', $order)->orderBy('second_name', $order)->orderBy('third_name', $order);
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
        $path = (new Helpers\HelpersController)->array2string($request->all()); // formatting url
        return view('panel.clients.index', [
            'data'        => $data->paginate(15),
            'path'        => $path,
            'filters'     => $search,
            'searchName'  => $request->get('name'),
            'searchPhone' => $request->get('phone'),
            'breadcrumb'  => [
                'title' => __('sidebar.clients'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('company.index'),
                            'name'   => __('sidebar.clients'),
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
        $data = Clients::with([
            'files', 'clientTypeRelation', 'clientIndustry', 'countriesShippingRelation', 'countriesBillingRelation',
            'citiesBilling', 'citiesShipping', 'clientGroupTypeRelation'
        ])->where('id',
            $id)->first();
        if ($data && $data->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$data) {
            return redirect()->route('main');
        }
        if (\Gate::denies('policy', 'guard_clients_view|guard_clients_view_self,'.$data->assigned_user_id)) {
            abort(403);
        }
        return view('panel.clients.view', [
            'item'       => $data,
            'breadcrumb' => [
                'title' => __('client.view'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('client.index'),
                            'name'   => __('sidebar.clients'),
                            'active' => false
                        ], [
                            'link'   => route('client.info', $data->id),
                            'name'   => $data->fullname(),
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }

    /**
     * @param  int|null  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function form(?int $id = null)
    {
        $country = Country::all();
        if ($id === null) {
            $title = __('client.create');
            $model = new Clients();
        } else {
            $title = __('client.edit');

            $model = Clients::with('files')->where('id', $id)->first();
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$model) {
            return redirect()->route('main');
        }
        if ($id && \Gate::denies('policy', 'guard_clients_edit|guard_clients_edit_self,'.$model->assigned_user_id)) {
            abort(403);
        }
        $client_types       = ClientType::whereSpaceId(\Auth::user()->space_id)->get();
        $industries         = Industry::whereSpaceId(\Auth::user()->space_id)->get();
        $client_group_types = ClientGroupType::whereSpaceId(\Auth::user()->space_id)->get();
        $assigned_user_id   = old('assigned_user_id', $model->assigned_user_id);
        $assignedUserInfo   = User::where('id', $assigned_user_id)->first();

        $billing_address_city = old('billing_address_city', $model->billing_address_city);
        $billingCityInfo      = City::where('id', $billing_address_city)->first();

        $shipping_address_city = old('shipping_address_city', $model->shipping_address_city);
        $shippingCityInfo      = City::where('id', $shipping_address_city)->first();
        return view('panel.clients.form', [
            'item'               => $model,
            'client_types'       => $client_types,
            'industries'         => $industries,
            'client_group_types' => $client_group_types,
            'assignedUserInfo'   => $assignedUserInfo,
            'billingCityInfo'    => $billingCityInfo,
            'shippingCityInfo'   => $shippingCityInfo,
            'breadcrumb'         => [
                'title' => $title,
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('client.index'),
                            'name'   => __('sidebar.clients'),
                            'active' => true
                        ], [
                            'link'   => route('client.create'),
                            'name'   => __('client.create'),
                            'active' => true
                        ],
                    ]
            ],
            'country'            => $country,
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
            $clients = new Clients();
        } else {
            $clients = Clients::find($id);
            if ($clients && $clients->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$clients) {
            return redirect()->route('main');
        }

        if ($id && \Gate::denies('policy', 'guard_clients_edit|guard_clients_edit_self,'.$clients->assigned_user_id)) {
            abort(403);
        } elseif (\Gate::denies('policy', 'guard_clients_add')) {
            abort(403);
        }


        $f = $request->file('photo');
        if ($id !== null && $f && $clients->files) {
            $clients->files->delete();
        }

        $clients->name                         = $request->post('name');
        $clients->second_name                  = $request->post('second_name');
        $clients->third_name                   = $request->post('third_name');
        $clients->phone                        = $request->post('phone');
        $clients->client_type                  = $request->post('client_type');
        $clients->industry_id                  = $request->post('industry_id');
        $clients->description                  = $request->post('description');
        $clients->billing_address_street       = $request->post('billing_address_street');
        $clients->billing_address_city         = $request->post('billing_address_city');
        $clients->billing_address_state        = $request->post('billing_address_state');
        $clients->billing_address_country      = $request->post('billing_address_country');
        $clients->billing_address_postal_code  = $request->post('billing_address_postal_code');
        $clients->billing_name_bank            = $request->post('billing_name_bank');
        $clients->sic                          = $request->post('sic');
        $clients->shipping_address_street      = $request->post('shipping_address_street');
        $clients->shipping_address_city        = $request->post('shipping_address_city');
        $clients->shipping_address_state       = $request->post('shipping_address_state');
        $clients->shipping_address_country     = $request->post('shipping_address_country');
        $clients->shipping_address_postal_code = $request->post('shipping_address_postal_code');
        $clients->assigned_user_id             = $request->post('assigned_user_id') ?? Auth::id();
        $clients->billing_bank_account         = $request->post('billing_bank_account');
        $clients->group_id                     = $request->post('group_id');
        $clients->space_id                     = Auth::user()->space_id;
        $clients->save();
        if ($f) {
            $file             = new Files();
            $file->name       = $f->getClientOriginalName();
            $file->ext        = $f->getClientOriginalExtension();
            $file->size       = $f->getSize();
            $file->model_type = 'App\Models\Clients';
            $file->model_id   = $clients->id;
            $file->space_id   = Auth::user()->space_id;
            $file->file       = $f->storePublicly('clients');
            $file->save();
        }
        return redirect()->route('client.index')->with('success', __('client.save'));
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request, int $id): RedirectResponse
    {
        $client = Clients::with('files')->where('id', $id)->first();
        if ($client && $client->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$client) {
            return redirect()->route('main');
        }

        if (\Gate::denies('policy', 'guard_clients_delete|guard_clients_delete_self,'.$client->assigned_user_id)) {
            abort(403);
        }

        if ($client->files) {
            $client->files->delete();
        }

        $client->delete();
        return redirect()->route('client.index')->with('success', __('client.deleted'));
    }

    /**
     * @param $request
     * @throws \Illuminate\Validation\ValidationException
     */

    public function validateFields($request, $id)
    {
        $messages = [
            'name.required'                         => __('client.errors.name'),
            'second_name.required'                  => __('client.errors.second_name'),
            'third_name.required'                   => __('client.errors.third_name'),
            'phone.required'                        => __('client.errors.phone'),
            'client_type.required'                  => __('client.errors.client_type'),
            'client_type.numeric'                   => __('client.errors.client_type'),
            'client_type.exists'                    => __('client.errors.client_type'),
            'industry_id.required'                  => __('client.errors.industry_id'),
            'industry_id.exists'                    => __('client.errors.industry_id'),
            'industry_id.numeric'                   => __('client.errors.industry_id'),
            'billing_address_street.required'       => __('client.errors.billing_address_street'),
            'billing_address_city.required'         => __('client.errors.billing_address_city'),
            'billing_address_city.exists'           => __('client.errors.billing_address_city'),
            'billing_address_city.numeric'          => __('client.errors.billing_address_city'),
            'billing_address_state.required'        => __('client.errors.billing_address_state'),
            'billing_address_country.required'      => __('client.errors.billing_address_country'),
            'billing_address_country.numeric'       => __('client.errors.billing_address_country'),
            'billing_address_country.exists'        => __('client.errors.billing_address_country'),
            'billing_address_postal_code.required'  => __('client.errors.billing_address_postal_code'),
            'billing_name_bank.required'            => __('client.errors.billing_name_bank'),
            'sic.required'                          => __('client.errors.sic'),
            'shipping_address_street.required'      => __('client.errors.shipping_address_street'),
            'shipping_address_city.required'        => __('client.errors.shipping_address_city'),
            'shipping_address_city.numeric'         => __('client.errors.shipping_address_city'),
            'shipping_address_city.exists'          => __('client.errors.shipping_address_city'),
            'shipping_address_state.required'       => __('client.errors.shipping_address_state'),
            'shipping_address_country.required'     => __('client.errors.shipping_address_country'),
            'shipping_address_country.numeric'      => __('client.errors.shipping_address_country'),
            'shipping_address_country.exists'       => __('client.errors.shipping_address_country'),
            'shipping_address_postal_code.required' => __('client.errors.shipping_address_postal_code'),
            'assigned_user_id.required'             => __('client.errors.assigned_user_id'),
            'billing_bank_account.required'         => __('client.errors.billing_bank_account'),
            'group_id.required'                     => __('client.errors.group_id'),
            'group_id.numeric'                      => __('client.errors.group_id'),
            'group_id.exists'                       => __('client.errors.group_id'),
            'photo.required'                        => __('client.errors.photo'),
            'photo.image'                           => __('client.errors.photo'),
            'photo.mimes'                           => __('client.errors.photo'),
            'photo.max'                             => __('client.errors.photo'),
        ];
        if ($id === null) {
            $this->validate($request, [
                'name'                         => 'required',
                'second_name'                  => 'nullable',
                'third_name'                   => 'nullable',
                'phone'                        => 'required',
                'client_type'                  => 'required|numeric|exists:client_type,id',
                'industry_id'                  => 'nullable|numeric|exists:industry,id',
                'billing_address_street'       => 'nullable',
                'billing_address_state'        => 'nullable',
                'billing_name_bank'            => 'nullable',
                'billing_address_country'      => 'nullable|numeric|exists:country,id',
                'billing_address_city'         => 'nullable|numeric|exists:city,id',
                'billing_address_postal_code'  => 'nullable',
                'sic'                          => 'nullable',
                'shipping_address_street'      => 'nullable',
                'shipping_address_city'        => 'nullable|numeric|exists:city,id',
                'shipping_address_state'       => 'nullable',
                'shipping_address_country'     => 'nullable|numeric|exists:country,id',
                'shipping_address_postal_code' => 'nullable',
                'assigned_user_id'             => 'nullable|numeric|exists:users,id',
                'billing_bank_account'         => 'nullable',
                'group_id'                     => 'nullable|numeric|exists:client_group_type,id',
                'photo'                        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
                $messages
            );
        } else {
            $this->validate($request, [
                'name'                         => 'required',
                'second_name'                  => 'nullable',
                'third_name'                   => 'nullable',
                'phone'                        => 'required',
                'client_type'                  => 'required|numeric|exists:client_type,id',
                'industry_id'                  => 'nullable|numeric|exists:industry,id',
                'billing_address_street'       => 'nullable',
                'billing_address_state'        => 'nullable',
                'billing_name_bank'            => 'nullable',
                'billing_address_country'      => 'nullable|numeric|exists:country,id',
                'billing_address_city'         => 'nullable|numeric|exists:city,id',
                'billing_address_postal_code'  => 'nullable',
                'sic'                          => 'nullable',
                'shipping_address_street'      => 'nullable',
                'shipping_address_city'        => 'nullable|numeric|exists:city,id',
                'shipping_address_state'       => 'nullable',
                'shipping_address_country'     => 'nullable|numeric|exists:country,id',
                'shipping_address_postal_code' => 'nullable',
                'assigned_user_id'             => 'nullable|numeric|exists:users,id',
                'billing_bank_account'         => 'nullable',
                'group_id'                     => 'nullable|numeric|exists:client_group_type,id',
                'photo'                        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
                $messages
            );
        }
    }
}
