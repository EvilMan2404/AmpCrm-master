<?php

namespace App\Http\Controllers\Requests;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
use App\Models\Catalog;
use App\Models\City;
use App\Models\ClientGroupType;
use App\Models\Clients;
use App\Models\ClientType;
use App\Models\Company;
use App\Models\Country;
use App\Models\Industry;
use App\Models\IssuanceOfFinance;
use App\Models\Lots;
use App\Models\Permissions;
use App\Models\Purchase;
use App\Models\PurchasePaymentType;
use App\Models\PurchaseReport;
use App\Models\PurchaseReportHasWastes;
use App\Models\PurchaseStatus;
use App\Models\Roles;
use App\Models\Spaces;
use App\Models\Stock;
use App\Models\Task;
use App\Models\TasksPriorities;
use App\Models\TasksStatuses;
use App\Models\Teams;
use App\Models\User;
use App\Models\WasteTypes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

/**
 * Class ServicesController
 * @package App\Http\Controllers\Requests
 */
class ServicesController extends Controller
{
    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getCities(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'country' => 'required|numeric|exists:country,id',
            ]);
            if ($validator->passes()) {
                $q       = $request->post('q');
                $take    = $this->getAmountOfTakenRows($q);
                $country = Country::find($request->post('country'));
                // $cities = $country->cities;
                $cities      = City::where('country_id', $country->id)->where('title', 'LIKE',
                    '%'.$request->post('q').'%')->take($take)->get();
                $citiesArr   = [];
                $citiesArr[] = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                foreach ($cities as $city) {
                    $citiesArr[] = [
                        'id'   => $city->id,
                        'text' => $city->title
                    ];
                }

                return response()->json($citiesArr);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getCategories(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $q          = $request->post('q');
            $take       = $this->getAmountOfTakenRows($q);
            $categories = array();
            if (\Gate::allows('policy', 'guard_catalog_view|guard_catalog_view_self')) {
                $categories = Catalog::where(static function ($query) {
                    if (\Gate::allows('policy', 'guard_catalog_view')) {
                        $query->where('space_id',
                            Auth::user()->space_id);
                    } elseif (\Gate::allows('policy', 'guard_catalog_view_self')) {
                        $query->where('user_id',
                            Auth::id());
                    }
                })->where(static function (Builder $query) use (
                    $request
                ) {
                    $query->where('name', 'like', '%'.$request->post('q').'%')
                        ->orWhereHas('carIdRelation', static function (Builder $query) use ($request) {
                            $query->where('name', 'like', '%'.$request->post('q').'%');
                        })
                        ->orWhere('serial_number', 'like', '%'.$request->post('q').'%');
                })
                    ->with('carIdRelation')
                    ->take($take)
                    ->get();
            }
            $result   = [];
            $result[] = [
                'id'   => ' ',
                'text' => __('index.nothing')
            ];
            foreach ($categories as $value) {
                $result[] = [
                    'id'   => $value->id,
                    'text' => $value->name.' | '.$value->carIdRelation->name.' | '.$value->serial_number
                ];
            }
            return response()->json($result);
        }
        return response()->json(['not access']);
    }

    /**
     * @param  Request  $request
     * @param  null  $car_brand
     * @return JsonResponse
     */
    public function getSerialNumber(Request $request, $car_brand = null): JsonResponse
    {
        if ($request->ajax()) {
            $q          = $request->post('q');
            $take       = $this->getAmountOfTakenRows($q);
            $categories = Catalog::where(static function ($query) {
                if (\Gate::allows('policy', 'guard_catalog_view')) {
                    $query->where('space_id',
                        Auth::user()->space_id);
                } else {
                    $query->where('user_id',
                        Auth::id());
                }
            })->when($car_brand,
                static function (Builder $query) use (
                    $request,
                    $car_brand
                ) {
                    $query->where('serial_number', 'like', '%'.$request->post('q').'%')->where('car_brand', $car_brand);
                }, static function (Builder $query) use (
                    $request
                ) {
                    $query->where('serial_number', 'like', '%'.$request->post('q').'%');
                })->groupBy('serial_number')->selectRaw('serial_number')
                ->take($take)
                ->get();
            $result     = [];
            $result[]   = [
                'id'   => ' ',
                'text' => __('index.nothing')
            ];
            foreach ($categories as $value) {
                $result[] = [
                    'id'   => $value->serial_number,
                    'text' => $value->serial_number
                ];
            }
            return response()->json($result);
        }
        return response()->json(['not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */

    public function getCompanyLots(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $q          = $request->post('q');
            $take       = $this->getAmountOfTakenRows($q);
            $categories = Lots::where(static function ($query) {
                if (\Gate::allows('policy', 'guard_lots_view_self')) {
                    $query->where('user_id',
                        Auth::id());
                } else {
                    $query->whereSpaceId(\Auth::user()->space_id);
                }
            })->whereHas('company',
                static function (Builder $query) use ($request) {
                    $query->where('name', 'like', '%'.$request->post('q').'%');
                })->when($request->get('name'), static function (Builder $query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
            })->when($request->get('name'), static function (Builder $query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
            })->when($request->get('company'), static function (Builder $query) use ($request) {
                $query->where('company_id', $request->get('company'));
            })->when($request->get('assigned'), static function (Builder $query) use ($request) {
                $query->where('assigned_user', $request->get('assigned'));
            })->when($request->get('owner'), static function (Builder $query) use ($request) {
                $query->where('user_id', $request->get('owner'));
            })->take($take)
                ->get();
            $result     = [];
            $result[]   = [
                'id'   => ' ',
                'text' => __('index.nothing')
            ];
            foreach ($categories as $value) {
                $result[] = [
                    'id'   => $value->company->id,
                    'text' => $value->company->name
                ];
            }
            return response()->json($result);
        }
        return response()->json(['not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */

    public function getLotsAssigned(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $q          = $request->post('q');
            $take       = $this->getAmountOfTakenRows($q);
            $categories = Lots::where(static function ($query) {
                if (\Gate::allows('policy', 'guard_lots_view_self')) {
                    $query->where('user_id',
                        Auth::id());
                } else {
                    $query->whereSpaceId(\Auth::user()->space_id);
                }
            })->whereHas('assigned',
                static function (Builder $query) use ($request) {
                    $query->where('name', 'like', '%'.$request->post('q').'%')
                        ->orWhere('second_name', 'like', '%'.$request->post('q').'%')
                        ->orWhere('third_name', 'like', '%'.$request->post('q').'%')
                        ->orWhere('email', 'like', '%'.$request->post('q').'%')
                        ->orWhere('phone', 'like', '%'.$request->post('q').'%');
                })->when($request->get('name'), static function (Builder $query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
            })->when($request->get('company'), static function (Builder $query) use ($request) {
                $query->where('company_id', $request->get('company'));
            })->when($request->get('assigned'), static function (Builder $query) use ($request) {
                $query->where('assigned_user', $request->get('assigned'));
            })->when($request->get('owner'), static function (Builder $query) use ($request) {
                $query->where('user_id', $request->get('owner'));
            })->take($take)
                ->get();
            $result     = [];
            $result[]   = [
                'id'   => ' ',
                'text' => __('index.nothing')
            ];
            foreach ($categories as $value) {
                $result[] = [
                    'id'   => $value->assigned->id,
                    'text' => $value->assigned->fullName()
                ];
            }
            return response()->json($result);
        }
        return response()->json(['not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getLotsOwner(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $q          = $request->post('q');
            $take       = $this->getAmountOfTakenRows($q);
            $categories = Lots::where(static function ($query) {
                if (\Gate::allows('policy', 'guard_lots_view_self')) {
                    $query->where('user_id',
                        Auth::id());
                } else {
                    $query->whereSpaceId(\Auth::user()->space_id);
                }
            })->whereHas('owner',
                static function (Builder $query) use ($request) {
                    $query->where('name', 'like', '%'.$request->post('q').'%')
                        ->orWhere('second_name', 'like', '%'.$request->post('q').'%')
                        ->orWhere('third_name', 'like', '%'.$request->post('q').'%')
                        ->orWhere('email', 'like', '%'.$request->post('q').'%')
                        ->orWhere('phone', 'like', '%'.$request->post('q').'%');
                })->when($request->get('name'), static function (Builder $query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
            })->when($request->get('company'), static function (Builder $query) use ($request) {
                $query->where('company_id', $request->get('company'));
            })->when($request->get('assigned'), static function (Builder $query) use ($request) {
                $query->where('assigned_user', $request->get('assigned'));
            })->when($request->get('owner'), static function (Builder $query) use ($request) {
                $query->where('user_id', $request->get('owner'));
            })->take($take)
                ->get();
            $result     = [];
            $result[]   = [
                'id'   => ' ',
                'text' => __('index.nothing')
            ];
            foreach ($categories as $value) {
                $result[] = [
                    'id'   => $value->owner->id,
                    'text' => $value->owner->fullName()
                ];
            }
            return response()->json($result);
        }
        return response()->json(['not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getPurchaseOwner(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $q          = $request->post('q');
            $take       = $this->getAmountOfTakenRows($q);
            $categories = Purchase::where(static function ($query) {
                if (\Gate::allows('policy', 'guard_purchase_view')) {
                    $query->whereSpaceId(\Auth::user()->space_id);
                } elseif (\Gate::allows('policy', 'guard_purchase_view_self')) {
                    $query->where('user_id',
                        Auth::id());
                }
            })->whereHas('owner',
                static function (Builder $query) use ($request) {
                    $query->where('name', 'like', '%'.$request->post('q').'%')
                        ->orWhere('second_name', 'like', '%'.$request->post('q').'%')
                        ->orWhere('third_name', 'like', '%'.$request->post('q').'%')
                        ->orWhere('email', 'like', '%'.$request->post('q').'%')
                        ->orWhere('phone', 'like', '%'.$request->post('q').'%');
                })->when($request->get('name'), static function (Builder $query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
            })->when($request->get('status'), static function (Builder $query) use ($request) {
                $query->where('status_id', $request->get('status'));
            })->when($request->get('owner'), static function (Builder $query) use ($request) {
                $query->where('user_id', $request->get('owner'));
            })->take($take)
                ->get();
            $result     = [];
            $result[]   = [
                'id'   => ' ',
                'text' => __('index.nothing')
            ];
            foreach ($categories as $value) {
                $result[$value->owner->id] = [
                    'id'   => $value->owner->id,
                    'text' => $value->owner->fullName()
                ];
            }
            return response()->json(array_values($result));
        }
        return response()->json(['not access']);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getPurchase(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $q          = $request->post('q');
            $take       = $this->getAmountOfTakenRows($q);
            $categories = Purchase::where(static function ($query) {
                if (\Gate::allows('policy', 'guard_purchase_view')) {
                    $query->where('space_id',
                        Auth::user()->space_id);
                } else {
                    $query->where('user_id',
                        Auth::id());
                }
            })->where('name', 'LIKE',
                '%'.$q.'%')->when($request->get('place') === 'stock', static function ($query) use ($request) {
                $query->whereHas('status', static function ($query) use ($request) {
                    $query->where('final', 1);
                });
            })->take($take)
                ->get();
            $result     = [];
            if ((string) $request->get('place') !== 'stock') {
                $result[] = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
            }

            foreach ($categories as $value) {
                $result[] = [
                    'id'   => $value->id,
                    'text' => $value->name
                ];
            }
            return response()->json($result);
        }
        return response()->json(['not access']);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function searchPurchase(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $q          = $request->post('q');
            $take       = $this->getAmountOfTakenRows($q);
            $categories = Purchase::where(static function ($query) {
                if (\Gate::allows('policy', 'guard_purchase_view')) {
                    $query->where('space_id',
                        Auth::user()->space_id);
                } else {
                    $query->where('user_id',
                        Auth::id());
                }
            })->where('name', 'LIKE',
                '%'.$request->get('name').'%')->when($request->get('status'),
                static function (Builder $query) use ($request) {
                    $query->where('status_id', $request->get('status'));
                })->take($take)
                ->get();
            $result     = [];
            $result[]   = [
                'id'   => ' ',
                'text' => __('index.nothing')
            ];
            foreach ($categories as $value) {
                $result[] = [
                    'id'   => $value->name,
                    'text' => $value->name
                ];
            }
            return response()->json($result);
        }
        return response()->json(['not access']);
    }

    /**
     * @param $q
     * @return int
     */
    public function getAmountOfTakenRows($q): int
    {
        if (empty($q)) {
            $take = 5;
        } else {
            $take = 100;
        }
        return $take;
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getLots(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'specific' => [
                'nullable', Rule::in(['name'])
            ],
        ]);
        if ($validator->passes() && $request->ajax()) {
            $q    = $request->post('q');
            $take = $this->getAmountOfTakenRows($q);
            $lots = array();
            if (\Gate::allows('policy', 'guard_lots_view|guard_lots_view_self')) {
                $lots = Lots::where(static function ($query) {
                    if (\Gate::allows('policy', 'guard_lots_view')) {
                        $query->where('space_id',
                            Auth::user()->space_id);
                    } elseif (\Gate::allows('policy', 'guard_lots_view_self')) {
                        $query->where('user_id',
                            Auth::id());
                    }
                })->when($request->get('specific'),
                    static function (Builder $query) use ($request) {
                        $query->where(static function (Builder $query) use ($request) {
                            $query->where($request->get('specific'), 'like',
                                '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                        })->when($request->get('name'), static function (Builder $query) use ($request) {
                            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
                        })->when($request->get('company'), static function (Builder $query) use ($request) {
                            $query->where('company_id', $request->get('company'));
                        })->when($request->get('assigned'), static function (Builder $query) use ($request) {
                            $query->where('assigned_user', $request->get('assigned'));
                        })->when($request->get('owner'), static function (Builder $query) use ($request) {
                            $query->where('user_id', $request->get('owner'));
                        });
                    }, function (Builder $query) use ($request) {
                        $query->where(static function (Builder $query) use (
                            $request
                        ) {
                            $query->
                            where('name', 'like', '%'.$request->post('q').'%')
                                ->orWhereHas('company', static function (Builder $query) use ($request) {
                                    $query->where('name', 'like', '%'.$request->post('q').'%');
                                });
                        });
                    })
                    ->with(['company', 'owner'])
                    ->take($take)
                    ->get();
            }
            $result   = [];
            $result[] = [
                'id'   => ' ',
                'text' => __('index.nothing')
            ];
            foreach ($lots as $value) {
                if (!$request->get('specific')) {
                    $result[] = [
                        'id'   => $value->id,
                        'text' => $value->name
                    ];
                } else {
                    $specific = $request->get('specific');
                    $result[] = [
                        'id'   => $value->$specific,
                        'text' => $value->$specific
                    ];
                }
            }
            return response()->json($result);
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getTeams(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'specific' => [
                'nullable', Rule::in(['name'])
            ],
        ]);
        if ($request->ajax() && $validator->passes()) {
            $q        = $request->post('q');
            $take     = $this->getAmountOfTakenRows($q);
            $teams    = Teams::whereSpaceId(\Auth::user()->space_id)
                ->when($request->get('specific'), static function (Builder $builder) use ($request) {
                    $builder->where(static function (Builder $builder) use ($request) {
                        $builder->where($request->get('specific'), 'like',
                            '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                    })->when($request->get('name'), static function (Builder $query) use ($request) {
                        $query->where('name', 'LIKE', '%'.$request->get('name').'%');
                    });
                }, static function (Builder $builder) use ($q) {
                    $builder->where('name', 'LIKE', '%'.$q.'%');
                })
                ->take($take)
                ->get();
            $result   = [];
            $result[] = [
                'id'   => ' ',
                'text' => __('index.nothing')
            ];
            $id       = $request->get('specific') ?? 'id';
            $text     = $request->get('specific') ?? 'name';

            foreach ($teams as $value) {
                $result[] = [
                    'id'   => $value->$id,
                    'text' => $value->$text
                ];
            }
            return response()->json($result);
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getPurchaseStatuses(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'specific' => [
                'nullable', Rule::in(['name'])
            ],
        ]);
        if ($request->ajax() && $validator->passes()) {
            $q        = $request->post('q');
            $take     = $this->getAmountOfTakenRows($q);
            $teams    = PurchaseStatus::whereSpaceId(\Auth::user()->space_id)
                ->when($request->get('specific'), static function (Builder $builder) use ($request) {
                    $builder->where(static function (Builder $builder) use ($request) {
                        $builder->where($request->get('specific'), 'like',
                            '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                    })->when($request->get('name'), static function (Builder $query) use ($request) {
                        $query->where('name', 'LIKE', '%'.$request->get('name').'%');
                    });
                }, static function (Builder $builder) use ($q) {
                    $builder->where('name', 'LIKE', '%'.$q.'%');
                })
                ->take($take)
                ->get();
            $result   = [];
            $result[] = [
                'id'   => ' ',
                'text' => __('index.nothing')
            ];
            $id       = $request->get('specific') ?? 'id';
            $text     = $request->get('specific') ?? 'name';

            foreach ($teams as $value) {
                $result[] = [
                    'id'   => $value->$id,
                    'text' => $value->$text
                ];
            }
            return response()->json($result);
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getPurchasePaymentTypes(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'specific' => [
                'nullable', Rule::in(['name'])
            ],
        ]);
        if ($request->ajax() && $validator->passes()) {
            $q        = $request->post('q');
            $take     = $this->getAmountOfTakenRows($q);
            $teams    = PurchasePaymentType::whereSpaceId(\Auth::user()->space_id)
                ->when($request->get('specific'), static function (Builder $builder) use ($request) {
                    $builder->where(static function (Builder $builder) use ($request) {
                        $builder->where($request->get('specific'), 'like',
                            '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                    })->when($request->get('name'), static function (Builder $query) use ($request) {
                        $query->where('name', 'LIKE', '%'.$request->get('name').'%');
                    });
                }, static function (Builder $builder) use ($q) {
                    $builder->where('name', 'LIKE', '%'.$q.'%');
                })
                ->take($take)
                ->get();
            $result   = [];
            $result[] = [
                'id'   => ' ',
                'text' => __('index.nothing')
            ];
            $id       = $request->get('specific') ?? 'id';
            $text     = $request->get('specific') ?? 'name';

            foreach ($teams as $value) {
                $result[] = [
                    'id'   => $value->$id,
                    'text' => $value->$text
                ];
            }
            return response()->json($result);
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getSpaces(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => [
                    'nullable', Rule::in(['title'])
                ],
            ]);
            if ($validator->passes()) {
                $q        = $request->post('q');
                $take     = $this->getAmountOfTakenRows($q);
                $stocks   = Spaces::when($request->get('specific'),
                    static function (Builder $query) use ($request) {
                        $query->where(static function (Builder $query) use ($request) {
                            $query->where($request->get('specific'), 'like',
                                '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                        })->when($request->get('name'), static function (Builder $query) use ($request) {
                            $query->where('title', 'like',
                                '%'.$request->get('name').'%');
                        });
                    }, static function (Builder $query) use (
                        $request
                    ) {
                        $query->where('title', 'like', '%'.$request->post('q').'%');
                    })->take($take)
                    ->get();
                $result   = [];
                $result[] = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id       = $request->get('specific') ?? 'id';
                $text     = $request->get('specific') ?? 'name';

                foreach ($stocks as $value) {
                    $result[] = [
                        'id'   => $value->$id,
                        'text' => $value->$text
                    ];
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }


    /**
     * @param  Request  $request
     * @param  null  $specific
     * @return JsonResponse
     */
    public function getCompanies(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => [
                    'nullable', Rule::in(['name', 'website', 'email', 'phone', 'billing_address', 'payment_info'])
                ],
            ]);
            if ($validator->passes()) {
                $q         = $request->post('q');
                $take      = $this->getAmountOfTakenRows($q);
                $companies = array();
                if (\Gate::allows('policy', 'guard_company_view|guard_company_view_self')) {
                    $companies = Company::where(static function ($query) {
                        if (\Gate::allows('policy', 'guard_company_view')) {
                            $query->whereSpaceId(\Auth::user()->space_id);
                        } else {
                            $query->where('user_id',
                                Auth::id());
                        }
                    })->when($request->get('specific'),
                        static function (Builder $query) use ($request) {
                            $query->where(static function (Builder $query) use ($request) {
                                $query->where($request->get('specific'), 'like',
                                    '%'.$request->post('q').'%')->orWhere($request->get('specific'),
                                    $request->post('q'));
                            })->when($request->get('name'), static function (Builder $query) use ($request) {
                                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
                            })->when($request->get('phone'), static function (Builder $query) use ($request) {
                                $query->where('phone', 'LIKE', '%'.$request->get('phone').'%');
                            })->when($request->get('email'), static function (Builder $query) use ($request) {
                                $query->where('email', 'LIKE', '%'.$request->get('email').'%');
                            })->when($request->get('website'), static function (Builder $query) use ($request) {
                                $query->where('website', 'LIKE', '%'.$request->get('website').'%');
                            })->when($request->get('payment_info'), static function (Builder $query) use ($request) {
                                $query->where('payment_info', 'LIKE', '%'.$request->get('payment_info').'%');
                            })->when($request->get('billing_address'), static function (Builder $query) use ($request) {
                                $query->where('billing_address', 'LIKE', '%'.$request->get('billing_address').'%');
                            });
                        }, static function (Builder $query) use (
                            $request
                        ) {
                            $query->where(static function ($query) use ($request) {
                                $query->where('name', 'like', '%'.$request->post('q').'%')
                                    ->orWhere('website', 'like', '%'.$request->post('q').'%')
                                    ->orWhere('phone', 'like', '%'.$request->post('q').'%');
                            });
                        })->take($take)
                        ->get();
                }
                $result   = [];
                $result[] = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id       = $request->get('specific') ?? 'id';
                $text     = $request->get('specific') ?? 'name';

                foreach ($companies as $value) {
                    $result[] = [
                        'id'   => $value->$id,
                        'text' => $value->$text
                    ];
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @param  null  $specific
     * @return JsonResponse
     */
    public function getStocks(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => [
                    'nullable', Rule::in(['name', 'date'])
                ],
                'userId'   => [
                    'nullable', 'exists:users,id'
                ]
            ]);
            if ($validator->passes()) {
                $dates    = PurchaseReport::getPreviousWeek();
                $q        = $request->post('q');
                $take     = $this->getAmountOfTakenRows($q);
                $stocks   = Stock::where(static function ($query) {
                    if (\Gate::allows('policy', 'guard_stock_view')) {
                        $query->where('space_id',
                            Auth::user()->space_id);
                    } else {
                        $query->where('user_id',
                            Auth::id());
                    }
                })->when($request->get('specific'),
                    static function (Builder $query) use ($request, $dates) {
                        $query->where(static function (Builder $query) use ($request) {
                            $query->where($request->get('specific'), 'like',
                                '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                        })->when($request->get('name'), static function (Builder $query) use ($request) {
                            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
                        })->when($request->get('date'), static function (Builder $query) use ($request) {
                            $query->where('date', 'LIKE', '%'.$request->get('date').'%');
                        })->when($request->get('owner'), static function (Builder $query) use ($request) {
                            $query->where('user_id', $request->get('owner'));
                        });
                    }, static function (Builder $query) use (
                        $dates,
                        $request
                    ) {
                        $query->when($request->post('purchaseReport'), static function ($query) use ($request, $dates) {
                            $query->where(static function ($query) use ($request, $dates) {
                                $query->where('name', 'like', '%'.$request->post('q').'%')
                                    ->orWhere('date', 'like',
                                        '%'.$request->post('q').'%');
                            })->where(static function ($query) use ($request, $dates) {
                                $query->when($dates['start'] || $dates['end'],
                                    static function ($query) use ($request, $dates) {
                                        $query->whereBetween('date',
                                            [
                                                $dates['start'] ?? '0000-00-00',
                                                $dates['end'] ?? '9999-09-09'
                                            ]);
                                    });
                            })->where('user_id', $request->post('userId'));
                        }, static function ($query) use ($request, $dates) {
                            $query->where(static function ($query) use ($request, $dates) {
                                $query->where('name', 'like', '%'.$request->post('q').'%')
                                    ->orWhere('date', 'like',
                                        '%'.$request->post('q').'%');
                            })->where(static function ($query) use ($request, $dates) {
                                $query->when($dates['start'] || $dates['end'],
                                    static function ($query) use ($request, $dates) {
                                        $query->whereBetween('date',
                                            [
                                                $dates['start'] ?? '0000-00-00',
                                                $dates['end'] ?? '9999-09-09'
                                            ]);
                                    });
                            });
                        });
                    })->take($take)
                    ->get();
                $result   = [];
                $result[] = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id       = $request->get('specific') ?? 'id';
                $text     = $request->get('specific') ?? 'name';

                foreach ($stocks as $value) {
                    $result[] = [
                        'id'   => $value->$id,
                        'text' => $value->$text
                    ];
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getStockOwner(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $q        = $request->post('q');
            $take     = $this->getAmountOfTakenRows($q);
            $owners   = Stock::where(static function ($query) {
                if (\Gate::allows('policy', 'guard_stock_view')) {
                    $query->where('space_id',
                        Auth::user()->space_id);
                } else {
                    $query->where('user_id',
                        Auth::id());
                }
            })->whereHas('userRelation',
                static function (Builder $query) use ($request) {
                    $query->where('name', 'like', '%'.$request->post('q').'%')
                        ->orWhere('second_name', 'like', '%'.$request->post('q').'%')
                        ->orWhere('third_name', 'like', '%'.$request->post('q').'%');
                })->when($request->get('name'), static function (Builder $query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
            })->when($request->get('date'), static function (Builder $query) use ($request) {
                $query->where('date', 'LIKE', '%'.$request->get('date').'%');
            })->when($request->get('owner'), static function (Builder $query) use ($request) {
                $query->where('user_id', $request->get('owner'));
            })->take($take)
                ->get();
            $result   = [];
            $result[] = [
                'id'   => ' ',
                'text' => __('index.nothing')
            ];
            foreach ($owners as $value) {
                $result[] = [
                    'id'   => $value->userRelation->id,
                    'text' => $value->userRelation->fullName()
                ];
            }
            return response()->json($result);
        }
        return response()->json(['not access']);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getPurchaseReportOwner(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $q        = $request->post('q');
            $take     = $this->getAmountOfTakenRows($q);
            $owners   = PurchaseReport::where(static function ($query) {
                if (\Gate::allows('policy', 'guard_purchaseReports_view')) {
                    $query->where('space_id',
                        Auth::user()->space_id);
                } else {
                    $query->where('user_id',
                        Auth::id());
                }
            })->whereHas('owner',
                static function (Builder $query) use ($request) {
                    $query->where('name', 'like', '%'.$request->post('q').'%')
                        ->orWhere('second_name', 'like', '%'.$request->post('q').'%')
                        ->orWhere('third_name', 'like', '%'.$request->post('q').'%');
                })->when($request->get('name'), static function (Builder $query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
            })->when($request->get('owner'), static function (Builder $query) use ($request) {
                $query->where('user_id', $request->get('owner'));
            })->take($take)
                ->get();
            $result   = [];
            $result[] = [
                'id'   => ' ',
                'text' => __('index.nothing')
            ];
            foreach ($owners as $value) {
                $result[] = [
                    'id'   => $value->owner->id,
                    'text' => $value->owner->fullName()
                ];
            }
            return response()->json($result);
        }
        return response()->json(['not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getUsers(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => [
                    'nullable', Rule::in(['fullname', 'email', 'phone'])
                ],
            ]);
            if ($validator->passes()) {
                $users = array();
                if (\Gate::allows('policy', 'guard_users_view|guard_users_view_self')) {
                    $users = User::where(static function ($query) {
                        if (\Gate::allows('policy', 'guard_users_view')) {
                            $query->where('space_id',
                                Auth::user()->space_id);
                        } elseif (\Gate::allows('policy', 'guard_users_view_self')) {
                            $query->where('assigned_user',
                                Auth::id());
                        }
                    })->when($request->get('specific'),
                        static function (Builder $query) use ($request) {
                            $query->where(static function (Builder $query) use ($request) {
                                if ($request->get('specific') === 'fullname') {
                                    $name = explode(' ', $request->get('q'));
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
                                } else {
                                    $query->where($request->get('specific'), 'like', '%'.$request->post('q').'%')
                                        ->orWhere($request->get('specific'), $request->post('q'));
                                }
                            })->when($request->get('email'), static function (Builder $query) use ($request) {
                                $query->where('email', 'LIKE', '%'.$request->get('email').'%');
                            })->when($request->get('phone'), static function (Builder $query) use ($request) {
                                $query->where('phone', 'LIKE', '%'.$request->get('phone').'%');
                            })->when($request->get('name'), static function (Builder $query) use ($request) {
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
                        }, static function (Builder $builder) use ($request) {
                            $builder->where(static function (Builder $query) use (
                                $request
                            ) {
                                $query->where('name', 'like', '%'.$request->post('q').'%')
                                    ->orWhere('third_name', 'like', '%'.$request->post('q').'%')
                                    ->orWhere('second_name', 'like', '%'.$request->post('q').'%')
                                    ->orWhere('card_number', 'like', '%'.$request->post('q').'%')
                                    ->orWhere('phone', 'like', '%'.$request->post('q').'%');
                            });
                        })->get();
                }
                $result   = [];
                $result[] = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                foreach ($users as $value) {
                    if (!$request->get('specific')) {
                        $result[] = [
                            'id'   => $value->id,
                            'text' => $value->fullname().' | '.$value->email
                        ];
                    } elseif ($request->get('specific') === 'fullname') {
                        $result[] = [
                            'id'   => $value->fullname(),
                            'text' => $value->fullname()
                        ];
                    } else {
                        $specific = $request->get('specific');
                        $result[] = [
                            'id'   => $value->$specific,
                            'text' => $value->$specific
                        ];
                    }
                }
                return response()->json($result);
            }
        }
        return response()->json(['not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getIndustries(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => [
                    'nullable', Rule::in(['title'])
                ],
            ]);
            if ($validator->passes()) {
                $q          = $request->post('q');
                $take       = $this->getAmountOfTakenRows($q);
                $industries = Industry::whereSpaceId(\Auth::user()->space_id)
                    ->when($request->get('specific'), static function (Builder $builder) use ($request) {
                        $builder->where($request->get('specific'), 'LIKE', '%'.$request->post('q').'%');
                    }, static function (Builder $builder) use ($request) {
                        $builder->where('title', 'LIKE',
                            '%'.$request->post('q').'%');
                    })->when($request->get('name'), static function (Builder $builder) use ($request) {
                        $builder->where('title', 'LIKE', '%'.$request->get('name').'%');
                    })
                    ->take($take)
                    ->get();
                $result     = [];
                $result[]   = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id         = $request->get('specific') ?? 'id';
                $text       = $request->get('specific') ?? 'name';

                foreach ($industries as $value) {
                    $result[] = [
                        'id'   => $value->$id,
                        'text' => $value->$text
                    ];
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getCarBrand(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => [
                    'nullable', Rule::in(['name'])
                ],
            ]);
            if ($validator->passes()) {
                $q         = $request->post('q');
                $take      = $this->getAmountOfTakenRows($q);
                $carBrands = CarBrand::whereSpaceId(\Auth::user()->space_id)
                    ->when($request->get('specific'), static function (Builder $builder) use ($request) {
                        $builder->where($request->get('specific'), 'LIKE', '%'.$request->post('q').'%');
                    }, static function (Builder $builder) use ($request) {
                        $builder->where('title', 'LIKE',
                            '%'.$request->post('q').'%');
                    })->when($request->get('name'), static function (Builder $builder) use ($request) {
                        $builder->where('name', 'LIKE', '%'.$request->get('name').'%');
                    })
                    ->take($take)
                    ->get();
                $result    = [];
                $result[]  = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id        = $request->get('specific') ?? 'id';
                $text      = $request->get('specific') ?? 'name';

                foreach ($carBrands as $value) {
                    $result[] = [
                        'id'   => $value->$id,
                        'text' => $value->$text
                    ];
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getWasteTypes(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => [
                    'nullable', Rule::in(['name'])
                ],
            ]);
            if ($validator->passes()) {
                $q         = $request->post('q');
                $take      = $this->getAmountOfTakenRows($q);
                $carBrands = WasteTypes::whereSpaceId(\Auth::user()->space_id)
                    ->when($request->get('specific'), static function (Builder $builder) use ($request) {
                        $builder->where($request->get('specific'), 'LIKE', '%'.$request->post('q').'%');
                    }, static function (Builder $builder) use ($request) {
                        $builder->where('title', 'LIKE',
                            '%'.$request->post('q').'%');
                    })->when($request->get('name'), static function (Builder $builder) use ($request) {
                        $builder->where('name', 'LIKE', '%'.$request->get('name').'%');
                    })
                    ->take($take)
                    ->get();
                $result    = [];
                $result[]  = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id        = $request->get('specific') ?? 'id';
                $text      = $request->get('specific') ?? 'name';

                foreach ($carBrands as $value) {
                    $result[] = [
                        'id'   => $value->$id,
                        'text' => $value->$text
                    ];
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getClients(
        Request $request
    ): JsonResponse {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => [
                    'nullable', Rule::in(['fullname', 'email', 'phone'])
                ],
            ]);
            if ($validator->passes()) {
                $users = array();
                if (\Gate::allows('policy', 'guard_clients_view|guard_clients_view_self')) {
                    $users = Clients::where(static function ($query) {
                        if (\Gate::allows('policy', 'guard_clients_view')) {
                            $query->where('space_id',
                                Auth::user()->space_id);
                        } elseif (\Gate::allows('policy', 'guard_clients_view_self')) {
                            $query->where('assigned_user_id',
                                Auth::id());
                        }
                    })->when($request->get('specific'),
                        static function (Builder $query) use ($request) {
                            $query->where(static function (Builder $query) use ($request) {
                                if ($request->get('specific') === 'fullname') {
                                    $name = explode(' ', $request->get('q'));
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
                                } else {
                                    $query->where($request->get('specific'), 'like', '%'.$request->post('q').'%')
                                        ->orWhere($request->get('specific'), $request->post('q'));
                                }
                            })->when($request->get('phone'), static function (Builder $query) use ($request) {
                                $query->where('phone', 'LIKE', '%'.$request->get('phone').'%');
                            })->when($request->get('name'), static function (Builder $query) use ($request) {
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
                        }, static function (Builder $builder) use ($request) {
                            $builder->where(static function (Builder $query) use (
                                $request
                            ) {
                                $query->where('name', 'like', '%'.$request->post('q').'%')
                                    ->orWhere('third_name', 'like', '%'.$request->post('q').'%')
                                    ->orWhere('second_name', 'like', '%'.$request->post('q').'%')
                                    ->orWhere('phone', 'like', '%'.$request->post('q').'%');
                            });
                        })->get();
                }
                $result   = [];
                $result[] = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                foreach ($users as $value) {
                    if (!$request->get('specific')) {
                        $result[] = [
                            'id'   => $value->id,
                            'text' => $value->fullname()
                        ];
                    } elseif ($request->get('specific') === 'fullname') {
                        $result[] = [
                            'id'   => $value->fullname(),
                            'text' => $value->fullname()
                        ];
                    } else {
                        $specific = $request->get('specific');
                        $result[] = [
                            'id'   => $value->$specific,
                            'text' => $value->$specific
                        ];
                    }
                }
                return response()->json($result);
            }
        }
        return response()->json(['not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public
    function getClientTypes(
        Request $request
    ): JsonResponse {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => ['nullable', Rule::in(['title'])],
            ]);
            if ($validator->passes()) {
                $q           = $request->post('q');
                $take        = $this->getAmountOfTakenRows($q);
                $clientTypes = ClientType::whereSpaceId(\Auth::user()->space_id)
                    ->when($request->get('specific'), static function (Builder $builder) use ($request) {
                        $builder->where(static function (Builder $builder) use ($request) {
                            $builder->where($request->get('specific'), 'like',
                                '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                        })->when($request->get('name'), static function (Builder $query) use ($request) {
                            $query->where('title', 'LIKE', '%'.$request->get('name').'%');
                        });
                    }, static function (Builder $builder) use ($q) {
                        $builder->where('title', 'LIKE', '%'.$q.'%');
                    })
                    ->take($take)
                    ->get();
                $result      = [];
                $result[]    = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id          = $request->get('specific') ?? 'id';
                $text        = $request->get('specific') ?? 'title';

                foreach ($clientTypes as $value) {
                    $result[] = [
                        'id'   => $value->$id,
                        'text' => $value->$text
                    ];
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public
    function getClientTypeGroups(
        Request $request
    ): JsonResponse {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => ['nullable', Rule::in(['title'])],
            ]);
            if ($validator->passes()) {
                $q           = $request->post('q');
                $take        = $this->getAmountOfTakenRows($q);
                $clientTypes = ClientGroupType::whereSpaceId(\Auth::user()->space_id)
                    ->when($request->get('specific'), static function (Builder $builder) use ($request) {
                        $builder->where(static function (Builder $builder) use ($request) {
                            $builder->where($request->get('specific'), 'like',
                                '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                        })->when($request->get('name'), static function (Builder $query) use ($request) {
                            $query->where('title', 'LIKE', '%'.$request->get('name').'%');
                        });
                    }, static function (Builder $builder) use ($q) {
                        $builder->where('title', 'LIKE', '%'.$q.'%');
                    })
                    ->take($take)
                    ->get();
                $result      = [];
                $result[]    = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id          = $request->get('specific') ?? 'id';
                $text        = $request->get('specific') ?? 'title';

                foreach ($clientTypes as $value) {
                    $result[] = [
                        'id'   => $value->$id,
                        'text' => $value->$text
                    ];
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getTaskStatuses(
        Request $request
    ): JsonResponse {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => ['nullable', Rule::in(['name'])],
            ]);
            if ($validator->passes()) {
                $q           = $request->post('q');
                $take        = $this->getAmountOfTakenRows($q);
                $clientTypes = TasksStatuses::whereSpaceId(\Auth::user()->space_id)
                    ->when($request->get('specific'), static function (Builder $builder) use ($request) {
                        $builder->where(static function (Builder $builder) use ($request) {
                            $builder->where($request->get('specific'), 'like',
                                '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                        })->when($request->get('name'), static function (Builder $query) use ($request) {
                            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
                        });
                    }, static function (Builder $builder) use ($q) {
                        $builder->where('name', 'LIKE', '%'.$q.'%');
                    })
                    ->take($take)
                    ->get();
                $result      = [];
                $result[]    = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id          = $request->get('specific') ?? 'id';
                $text        = $request->get('specific') ?? 'name';

                foreach ($clientTypes as $value) {
                    $result[] = [
                        'id'   => $value->$id,
                        'text' => $value->$text
                    ];
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getTaskPriorities(
        Request $request
    ): JsonResponse {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => ['nullable', Rule::in(['name'])],
            ]);
            if ($validator->passes()) {
                $q           = $request->post('q');
                $take        = $this->getAmountOfTakenRows($q);
                $clientTypes = TasksPriorities::whereSpaceId(\Auth::user()->space_id)
                    ->when($request->get('specific'), static function (Builder $builder) use ($request) {
                        $builder->where(static function (Builder $builder) use ($request) {
                            $builder->where($request->get('specific'), 'like',
                                '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                        })->when($request->get('name'), static function (Builder $query) use ($request) {
                            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
                        });
                    }, static function (Builder $builder) use ($q) {
                        $builder->where('name', 'LIKE', '%'.$q.'%');
                    })
                    ->take($take)
                    ->get();
                $result      = [];
                $result[]    = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id          = $request->get('specific') ?? 'id';
                $text        = $request->get('specific') ?? 'name';

                foreach ($clientTypes as $value) {
                    $result[] = [
                        'id'   => $value->$id,
                        'text' => $value->$text
                    ];
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getTasks(
        Request $request
    ): JsonResponse {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => ['nullable', Rule::in(['name'])],
            ]);
            if ($validator->passes()) {
                $q           = $request->post('q');
                $take        = $this->getAmountOfTakenRows($q);
                $clientTypes = Task::where(static function ($query) {
                    if (\Gate::allows('policy', 'guard_tasks_view')) {
                        $query->where('space_id',
                            Auth::user()->space_id);
                    } else {
                        $query->where('user_id',
                            Auth::id());
                    }
                })
                    ->when($request->get('specific'), static function (Builder $builder) use ($request) {
                        $builder->where(static function (Builder $builder) use ($request) {
                            $builder->where($request->get('specific'), 'like',
                                '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                        })->when($request->get('name'), static function (Builder $query) use ($request) {
                            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
                        });
                    }, static function (Builder $builder) use ($q) {
                        $builder->where('name', 'LIKE', '%'.$q.'%');
                    })
                    ->take($take)
                    ->get();
                $result      = [];
                $result[]    = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id          = $request->get('specific') ?? 'id';
                $text        = $request->get('specific') ?? 'name';

                foreach ($clientTypes as $value) {
                    $result[] = [
                        'id'   => $value->$id,
                        'text' => $value->$text
                    ];
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getIssuance(
        Request $request
    ): JsonResponse {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => ['nullable', Rule::in(['name'])],
            ]);
            if ($validator->passes()) {
                $q        = $request->post('q');
                $take     = $this->getAmountOfTakenRows($q);
                $issuance = IssuanceOfFinance::whereSpaceId(\Auth::user()->space_id)
                    ->when($request->get('specific'), static function (Builder $builder) use ($request) {
                        $builder->where(static function (Builder $builder) use ($request) {
                            $builder->where($request->get('specific'), 'like',
                                '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                        })->when($request->get('name'), static function (Builder $query) use ($request) {
                            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
                        });
                    }, static function (Builder $builder) use ($q) {
                        $builder->where('name', 'LIKE', '%'.$q.'%');
                    })
                    ->take($take)
                    ->get();
                $result   = [];
                $result[] = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id       = $request->get('specific') ?? 'id';
                $text     = $request->get('specific') ?? 'name';

                foreach ($issuance as $value) {
                    $result[] = [
                        'id'   => $value->$id,
                        'text' => $value->$text
                    ];
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getPermissions(
        Request $request
    ): JsonResponse {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => ['nullable', Rule::in(['name', 'guard_name'])],
            ]);
            if ($validator->passes()) {
                $q           = $request->post('q');
                $take        = $this->getAmountOfTakenRows($q);
                $permissions = Permissions::when($request->get('specific'),
                    static function (Builder $builder) use ($request) {
                        $builder->where(static function (Builder $builder) use ($request) {
                            $builder->where($request->get('specific'), 'like',
                                '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                        })->when($request->get('name'), static function (Builder $query) use ($request) {
                            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
                        })->when($request->get('name'), static function (Builder $query) use ($request) {
                            $query->where('guard_name', 'LIKE', '%'.$request->get('guard_name').'%');
                        });
                    }, static function (Builder $builder) use ($q) {
                        $builder->where('name', 'LIKE', '%'.$q.'%')->orWhere('guard_name', 'LIKE',
                            '%'.$q.'%')->orWhere('desc', 'LIKE', '%'.$q.'%');
                    })
                    ->take($take)
                    ->get();
                $result      = [];
                $result[]    = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id          = $request->get('specific') ?? 'id';
                $text        = $request->get('specific') ?? 'name';

                foreach ($permissions as $value) {
                    if ($request->get('specific') === 'name') {
                        $id       = $request->get('specific');
                        $text     = $request->get('specific');
                        $result[] = [
                            'id'   => $value->$id,
                            'text' => $value->$text.' | '.$value->guard_name
                        ];
                    } else {
                        if ($request->get('type') === 'multi') {
                            $id = 'name';
                        } else {
                            $id = 'id';
                        }
                        $result[] = [
                            'id'   => $value->$id,
                            'text' => $value->name.' | '.$value->guard_name
                        ];
                    }
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getRoles(
        Request $request
    ): JsonResponse {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => ['nullable', Rule::in(['name', 'guard_name'])],
            ]);
            if ($validator->passes()) {
                $q        = $request->post('q');
                $take     = $this->getAmountOfTakenRows($q);
                $roles    = Roles::when($request->get('specific'),
                    static function (Builder $builder) use ($request) {
                        $builder->where(static function (Builder $builder) use ($request) {
                            $builder->where($request->get('specific'), 'like',
                                '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                        })->when($request->get('name'), static function (Builder $query) use ($request) {
                            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
                        })->when($request->get('name'), static function (Builder $query) use ($request) {
                            $query->where('guard_name', 'LIKE', '%'.$request->get('guard_name').'%');
                        });
                    }, static function (Builder $builder) use ($q) {
                        $builder->where('name', 'LIKE', '%'.$q.'%')->orWhere('guard_name', 'LIKE',
                            '%'.$q.'%');
                    })
                    ->take($take)
                    ->get();
                $result   = [];
                $result[] = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id       = $request->get('specific') ?? 'id';
                $text     = $request->get('specific') ?? 'name';

                foreach ($roles as $value) {
                    $result[] = [
                        'id'   => $value->$id,
                        'text' => $value->$text
                    ];
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getPurchaseReports(
        Request $request
    ): JsonResponse {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'specific' => ['nullable', Rule::in(['name'])],
            ]);
            if ($validator->passes()) {
                $q        = $request->post('q');
                $take     = $this->getAmountOfTakenRows($q);
                $roles    = PurchaseReport::when($request->get('specific'),
                    static function (Builder $builder) use ($request) {
                        $builder->where(static function (Builder $builder) use ($request) {
                            $builder->where($request->get('specific'), 'like',
                                '%'.$request->post('q').'%')->orWhere($request->get('specific'), $request->post('q'));
                        })->when($request->get('name'), static function (Builder $query) use ($request) {
                            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
                        })->when($request->get('owner'), static function (Builder $query) use ($request) {
                            $query->where('user_id', $request->get('owner'));
                        });
                    }, static function (Builder $builder) use ($q) {
                        $builder->where('name', 'LIKE', '%'.$q.'%');
                    })
                    ->take($take)
                    ->get();
                $result   = [];
                $result[] = [
                    'id'   => ' ',
                    'text' => __('index.nothing')
                ];
                $id       = $request->get('specific') ?? 'id';
                $text     = $request->get('specific') ?? 'name';

                foreach ($roles as $value) {
                    $result[] = [
                        'id'   => $value->$id,
                        'text' => $value->$text
                    ];
                }
                return response()->json($result);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public
    function getCatalog(
        Request $request
    ): JsonResponse {
        $categoriesValue = $request->post('categories');
        if (is_array($categoriesValue) && $request->ajax()) {
            $categories = Catalog::whereSpaceId(\Auth::user()->space_id)
                ->whereIn('id', $categoriesValue)->get()->toArray();
            return response()->json(is_array($categories) ? $categories : []);
        }
        return response()->json(['error' => 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public
    function getPurchaseInfo(
        Request $request
    ): JsonResponse {
        $categoriesValue = $request->post('purchases');
        if (is_array($categoriesValue) && $request->ajax()) {
            $purchases = Purchase::whereSpaceId(\Auth::user()->space_id)
                ->whereIn('id', $categoriesValue)->with(['catalogs', 'lot'])->get();

            foreach ($purchases as $item) {
                $item->count = 0;
                foreach ($item->catalogs as $catalog) {
                    $item->count += $catalog->pivot->count;
                }
                $item->ownerName = ($item->owner) ? $item->owner->fullName() : 'Владелец неизвестен';
            }
            $purchases = $purchases->toArray();

            return response()->json(is_array($purchases) ? $purchases : []);
        }
        return response()->json(['error' => 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public
    function getStockTotal(
        Request $request
    ): JsonResponse {
        $stockIds = $request->post('stocks');
        if (is_array($stockIds) && $request->ajax()) {
            $stocks       = Stock::whereSpaceId(\Auth::user()->space_id)
                ->whereIn('id', $stockIds)->with('purchases')->get();
            $stocks_array = array();
            foreach ($stocks as $item) {
                $stocks_array[$item->id]['name']  = $item->name;
                $stocks_array[$item->id]['total'] = 0;
                foreach ($item->purchases as $value) {
                    $stocks_array[$item->id]['total'] += $value->total;
                }
            }
            return response()->json(is_array($stocks_array) ? $stocks_array : []);
        }
        return response()->json(['error' => 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public
    function getWasteInfo(
        Request $request
    ): JsonResponse {
        $wasteIds = $request->post('wastes');
        if (is_array($wasteIds) && $request->ajax()) {
            $stocks = WasteTypes::whereSpaceId(\Auth::user()->space_id)
                ->whereIn('id', $wasteIds)->get()->toArray();
            foreach ($stocks as $key => $item) {
                $stocks[$key]['sum'] = 0;
                if ($request->post('id')) {
                    $reportInfo          = PurchaseReportHasWastes::where('report_id',
                        $request->post('id'))->where('waste_id', $item['id'])->first();
                    $stocks[$key]['sum'] = $reportInfo->sum ?? 0;
                }
            }
            return response()->json(is_array($stocks) ? $stocks : []);
        }
        return response()->json(['error' => 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public
    function getLot(
        Request $request
    ): JsonResponse {
        $lotValue = $request->post('lot');
        if ($lotValue && $request->ajax()) {
            $lot = Lots::whereSpaceId(\Auth::user()->space_id)
                ->whereId($lotValue)->first();
            if ($lot) {
                $lot = $lot->toArray();
            }
            return response()->json(is_array($lot) ? $lot : []);
        }
        return response()->json(['error' => 'not access']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public
    function getSource(
        Request $request
    ): JsonResponse {
        $validator = Validator::make($request->all(), [
            'source' => ['required'],
        ]);
        if ($request->ajax() && $validator->passes()) {
            if ($request->post('source') === Clients::class) {
                return $this->getClients($request);
            }

            if ($request->post('source') === Purchase::class) {
                return $this->getPurchase($request);
            }

            if ($request->post('source') === Company::class) {
                return $this->getCompanies($request);
            }

            if ($request->post('source') === Catalog::class) {
                return $this->getCategories($request);
            }
        }
        return response()->json(['error' => isset($validator) ? $validator->errors()->all() : 'not access']);
    }
}
