<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * App\Models\Clients
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $second_name
 * @property string|null $third_name
 * @property string|null $phone
 * @property string|null $client_type
 * @property string|null $industry_id
 * @property string|null $description
 * @property string|null $billing_address_street
 * @property string|null $billing_address_city
 * @property string|null $billing_address_state
 * @property string|null $billing_address_country
 * @property string|null $billing_name_bank
 * @property string|null $sic
 * @property string|null $shipping_address_street
 * @property string|null $shipping_address_city
 * @property string|null $shipping_address_state
 * @property string|null $shipping_address_country
 * @property string|null $shipping_address_postal_code
 * @property string|null $assigned_user_id
 * @property string|null $billing_bank_account
 * @property int|null $group_id
 * @property int|null $space_id
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clients newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clients query()
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereAssignedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereBillingAddressCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereBillingAddressCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereBillingAddressState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereBillingAddressStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereBillingBankAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereBillingNameBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereClientType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereIndustryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereSecondName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereShippingAddressCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereShippingAddressCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereShippingAddressPostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereShippingAddressState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereShippingAddressStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereSic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereThirdName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $billing_address_postal_code
 * @property-read \App\Models\User|null $assignedUser
 * @property-read \App\Models\City|null $citiesBilling
 * @property-read \App\Models\City|null $citiesShipping
 * @property-read \App\Models\ClientGroupType|null $clientGroupTypeRelation
 * @property-read \App\Models\Industry|null $clientIndustry
 * @property-read \App\Models\ClientType|null $clientTypeRelation
 * @property-read \App\Models\Country|null $countriesBillingRelation
 * @property-read \App\Models\Country|null $countriesShippingRelation
 * @property-read \App\Models\Files|null $files
 * @property-read \App\Models\ClientGroupType|null $groupIdRelation
 * @property-read \App\Models\Spaces|null $spaceIdRelation
 * @method static \Illuminate\Database\Eloquent\Builder|Clients whereBillingAddressPostalCode($value)
 */
class Clients extends BaseModel
{
    protected $table = 'clients';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $hidden = ['deleted_at'];
    protected $dates  = ['deleted_at'];

    protected $appends = [];

    public static function onCreateOrUpdateEvent($model)
    {
    }


    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            /* if ($model->getOriginal('account_status_id') !== $model->attributes['account_status_id']) {
            } */
        });
    }


    public static function index($params = [], $checkTimeOnly = false)
    {
        $data     = null;
        $fields   = ['id', 'title'];
        $instance = new static;

        if (!$checkTimeOnly) {
            $data = $instance->get($fields)->keyBy('id');
        }

        $r             = $instance->latest()->first();
        $indexLastTime = empty($r->updated_at) ? strtotime($r->created_at) : strtotime($r->updated_at);
        return [
            'data'        => $data,
            'filters'     => '',
            'params'      => $params,
            'server_time' => $indexLastTime
        ];
    }


    public function groupIdRelation()
    {
        return $this->belongsTo('App\Models\ClientGroupType',
            'group_id',
            'id');
    }


    public function spaceIdRelation()
    {
        return $this->belongsTo('App\Models\Spaces',
            'space_id',
            'title');
    }

    /**
     * @return BelongsTo
     */
    public function clientTypeRelation(): BelongsTo
    {
        return $this->belongsTo(ClientType::class,
            'client_type',
            'id');
    }

    /**
     * @return BelongsTo
     */

    public function clientGroupTypeRelation(): BelongsTo
    {
        return $this->belongsTo(ClientGroupType::class,
            'group_id',
            'id');
    }

    /**
     * @return BelongsTo
     */

    public function clientIndustry(): BelongsTo
    {
        return $this->belongsTo(Industry::class,
            'industry_id',
            'id');
    }

    /**
     * @return BelongsTo
     */

    public function countriesBillingRelation(): BelongsTo
    {
        return $this->belongsTo(Country::class,
            'billing_address_country',
            'id');
    }

    /**
     * @return BelongsTo
     */

    public function citiesBilling(): BelongsTo
    {
        return $this->belongsTo(City::class,
            'billing_address_city',
            'id');
    }

    /**
     * @return BelongsTo
     */

    public function citiesShipping(): BelongsTo
    {
        return $this->belongsTo(City::class,
            'shipping_address_city',
            'id');
    }

    /**
     * @return BelongsTo
     */

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class,
            'assigned_user_id',
            'id');
    }

    /**
     * @return BelongsTo
     */

    public function countriesShippingRelation(): BelongsTo
    {
        return $this->belongsTo(Country::class,
            'shipping_address_country',
            'id');
    }

    public function files(): MorphOne
    {
        return $this->morphOne(
            Files::class,
            'model'
        );
    }

    /**
     * @return string
     */
    public function fullName(): string
    {
        return $this->third_name.' '.$this->name.' '.$this->second_name;
    }


}
