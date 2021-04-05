<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\SpaceHasRole;
use App\Models\Spaces;
use App\Models\Teams;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $data = User::with([
            'teamIdRelation', 'assignedUser', 'countryRelation', 'cityRelation', 'spaceRelation'
        ])->where(static function ($query) {
            if (\Gate::allows('policy', 'guard_users_view')) {
                $query->where('space_id',
                    Auth::user()->space_id);
            } else {
                $query->where('assigned_user',
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
            if ($request->get('email')) {
                $query->where('email', 'LIKE', '%'.$request->get('email').'%');
            }
            if ($request->get('phone')) {
                $query->where('phone', 'LIKE', '%'.$request->get('phone').'%');
            }
        });


        /*sorting rows*/
        if ($request->get('sort_by') && $request->get('order')) {
            $validation_get = Validator::make($request->all(), [
                'sort_by' => [Rule::in(['fullname', 'email', 'balance', 'id'])],
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
            } else {
                $data->orderByDesc('id');
            }
        } else {
            $data->orderByDesc('id');
        }
        /*end sorting rows*/

        $path = (new Helpers\HelpersController)->array2string($request->all()); // formatting url
        return view('panel.users.index', [
            'data'        => $data->paginate(15),
            'path'        => $path,
            'searchName'  => $request->get('name'),
            'searchEmail' => $request->get('email'),
            'searchPhone' => $request->get('phone'),
            'breadcrumb'  => [
                'title' => __('sidebar.users'),
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
        $country = Country::all();
        if ($id === null) {
            $title = __('users.create');
            $model = new User();
        } else {
            $title = __('users.edit');

            $model = User::where('id', $id)->first();
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$model) {
            return redirect()->route('main');
        }

        if ($id && \Gate::denies('policy', 'guard_users_edit|guard_users_edit_self,'.$model->assigned_user)) {
            abort(403);
        }

        $assigned_user_id = old('assigned_user', $model->assigned_user);
        $assignedUserInfo = User::where('id', $assigned_user_id)->first();

        $city_id  = old('city_id', $model->city_id);
        $cityInfo = City::where('id', $city_id)->first();

        $team_id  = old('team_id', $model->team_id);
        $teamInfo = Teams::where('id', $team_id)->first();

        $space_id  = old('space_id', $model->space_id);
        $spaceInfo = Spaces::where('id', $space_id)->first();

        $roles      = SpaceHasRole::whereSpaceId(Auth::user()->space_id)->with('roleIdRelation')->get();
        $chosenRole = 0;
        if ($model->roles) {
            foreach ($model->roles as $role) {
                $chosenRole = $role->pivot->role_id;
            }
        }
        return view('panel.users.form', [
            'item'             => $model,
            'assignedUserInfo' => $assignedUserInfo,
            'cityInfo'         => $cityInfo,
            'teamInfo'         => $teamInfo,
            'spaceInfo'        => $spaceInfo,
            'roles'            => $roles,
            'chosenRole'       => $chosenRole,
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
            'country'          => $country,
        ]);
    }

    /**
     * @param  Request  $request
     * @param  int|null  $id
     * @return RedirectResponse
     */
    public function save(Request $request, ?int $id = null): RedirectResponse
    {
        $this->validateFields($request, $id);
        if ($id === null) {
            $model = new User();
        } else {
            $model = User::find($id);
            if ($model && $model->space_id !== \Auth::user()->space_id) {
                return redirect()->route('main');
            }
        }
        if (!$model) {
            return redirect()->route('main');
        }
        if ($id && \Gate::denies('policy', 'guard_users_edit|guard_users_edit_self,'.$model->assigned_user)) {
            abort(403);
        } elseif (\Gate::denies('policy', 'guard_users_add')) {
            abort(403);
        }

        $model->name          = $request->post('name');
        $model->second_name   = $request->post('second_name');
        $model->third_name    = $request->post('third_name');
        $model->phone         = $request->post('phone');
        $model->email         = $request->post('email');
        $model->assigned_user = $request->post('assigned_user') ?? Auth::id();
        $model->country_id    = $request->post('country_id');
        $model->city_id       = $request->post('city_id');
        $model->street        = $request->post('street');
        $model->address       = $request->post('address');
        $model->card_number   = $request->post('card_number');
        if ($request->post('password')) {
            $model->password = Hash::make($request->post('password'));
        }
        if (!$id || (\Gate::allows('policy', 'guard_users_teams') && $request->post('team_id'))) {
            $model->team_id = $request->post('team_id');
        }
        $model->space_id = $request->post('space_id') ?? Auth::user()->space_id;
        $model->save();
        if (!$id || (\Gate::allows('policy', 'guard_users_roles') && $request->post('role_id'))) {
            $model->roles()->sync([$request->post('role_id')]);
        }

        return redirect()->route('users.index')->with('success', __('users.save'));
    }

    /**
     * @param  int  $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function view(int $id)
    {
        $data = User::with([
            'teamIdRelation', 'assignedUser', 'countryRelation', 'cityRelation', 'spaceRelation'
        ])->where('id',
            $id)->first();
        if ($data && $data->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$data) {
            return redirect()->route('main');
        }

        if (\Gate::denies('policy', 'guard_users_view|guard_users_view_self,'.$data->assigned_user)) {
            abort(403);
        }

        return view('panel.users.view', [
            'item'       => $data,
            'breadcrumb' => [
                'title' => __('users.view'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('users.index'),
                            'name'   => __('sidebar.users'),
                            'active' => false
                        ], [
                            'link'   => route('users.info', $data->id),
                            'name'   => $data->fullname(),
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
        $model = User::where('id', $id)->first();
        if ($model && $model->space_id !== \Auth::user()->space_id) {
            return redirect()->route('main');
        }
        if (!$model) {
            return redirect()->route('main');
        }
        if (\Gate::denies('policy', 'guard_users_delete|guard_users_delete_self,'.$model->assigned_user)) {
            abort(403);
        }
        if ($model->id === Auth::id()) {
            return redirect()->route('users.index')->with('success', __('users.cantDeleteCurrent'));
        }

        $model->delete();
        return redirect()->route('users.index')->with('success', __('users.deleted'));
    }


    public function validateFields($request, $id)
    {
        $messages = [
            'name.required'          => __('users.errors.name'),
            'second_name.required'   => __('users.errors.second_name'),
            'third_name.required'    => __('users.errors.third_name'),
            'phone.required'         => __('users.errors.phone'),
            'email.required'         => __('users.errors.email'),
            'email.email'            => __('users.errors.email'),
            'assigned_user.required' => __('users.errors.assigned_user'),
            'assigned_user.numeric'  => __('users.errors.assigned_user'),
            'assigned_user.exists'   => __('users.errors.assigned_user'),
            'country_id.exists'      => __('users.errors.country_id'),
            'country_id.numeric'     => __('users.errors.country_id'),
            'country_id.required'    => __('users.errors.country_id'),
            'city_id.required'       => __('users.errors.city_id'),
            'city_id.numeric'        => __('users.errors.city_id'),
            'city_id.exists'         => __('users.errors.city_id'),
            'street.required'        => __('users.errors.street'),
            'address.required'       => __('users.errors.address'),
            'card_number.required'   => __('users.errors.card_number'),
            'card_number.numeric'    => __('users.errors.card_number'),
            'password.required'      => __('users.errors.password'),
            'password.min'           => __('users.errors.password'),
            'password.confirmed'     => __('users.errors.password'),
            'team_id.required'       => __('users.errors.team_id'),
            'team_id.numeric'        => __('users.errors.team_id'),
            'team_id.exists'         => __('users.errors.team_id'),
            'space_id.exists'        => __('users.errors.space_id'),
            'space_id.numeric'       => __('users.errors.space_id'),
            'space_id.required'      => __('users.errors.space_id'),

        ];
        if ($id === null) {
            $this->validate($request, [
                'name'          => 'required',
                'second_name'   => 'required',
                'third_name'    => 'required',
                'phone'         => 'required',
                'email'         => 'required|email',
                'assigned_user' => 'nullable|numeric|exists:users,id',
                'country_id'    => 'required|numeric|exists:country,id',
                'city_id'       => 'required|numeric|exists:city,id',
                'street'        => 'required',
                'address'       => 'required',
                'card_number'   => 'required|numeric',
                'password'      => 'required|min:3|confirmed',
                'team_id'       => 'required|numeric|exists:teams,id',
                'role_id'       => 'nullable|numeric|exists:roles,id',
                //  'space_id'      => 'required|numeric|exists:spaces,id',
            ],
                $messages
            );
        } else {
            $this->validate($request, [
                'name'          => 'required',
                'second_name'   => 'required',
                'third_name'    => 'required',
                'phone'         => 'required',
                'email'         => 'required|email',
                'assigned_user' => 'nullable|numeric|exists:users,id',
                'country_id'    => 'required|numeric|exists:country,id',
                'city_id'       => 'required|numeric|exists:city,id',
                'street'        => 'required',
                'address'       => 'required',
                'card_number'   => 'required|numeric',
                'password'      => 'nullable|min:3|confirmed',
                'team_id'       => 'nullable|numeric|exists:teams,id',
                'role_id'       => 'nullable|numeric|exists:roles,id',
                //  'space_id'      => 'required|numeric|exists:spaces,id',
            ],
                $messages
            );
        }
    }
}
