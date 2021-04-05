<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $logo_id
 * @property string|null $website
 * @property string|null $description
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $billing_address_country
 * @property string|null $billing_address_state
 * @property string|null $billing_address_city
 * @property string|null $billing_address_street
 * @property string|null $billing_address_postal_code
 * @property string|null $billing_address
 * @property string|null $shipping_address
 * @property string|null $payment_info
 * @property int|null $last_user_id
 * @property int|null $space_id
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereBillingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereBillingAddressCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereBillingAddressCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereBillingAddressPostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereBillingAddressState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereBillingAddressStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLastUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePaymentInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereShippingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereWebsite($value)
 * @mixin \Eloquent
 * @property-read \App\Models\City|null $citiesRelation
 * @property-read \App\Models\Country|null $countriesRelation
 * @property-read \App\Models\Files|null $files
 * @property-read \App\Models\User|null $userEdited
 * @property int|null $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUserId($value)
 */
class Company extends BaseModel {
    protected $table                = 'company';
    const CREATED_AT                = 'created_at';
    const UPDATED_AT                = 'updated_at';
    protected $hidden               = ['deleted_at'];
    protected $dates                = ['deleted_at'];

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
    public function files() : MorphOne
    {
        return $this->morphOne(
            Files::class,
            'model'
        );
    }

    public static function index($params = [], $checkTimeOnly = false) {
        $data = null;
        $fields = ['id','title'];
        $instance = new static;

        if (!$checkTimeOnly) {
            $data = $instance->get($fields)->keyBy('id');
        }

        $r = $instance->latest()->first();
        $indexLastTime = empty($r->updated_at)?strtotime($r->created_at):strtotime($r->updated_at);
        return [
            'data' => $data,
            'filters' => '',
            'params' => $params,
            'server_time' => $indexLastTime
        ];
    }


    public function logoIdRelation()
    {
        return $this-> belongsTo('App\Models\Files',
             'logo_id',
             'id');
    }


    public function userEdited()
    {
        return $this->belongsTo('App\Models\User',
             'last_user_id',
             'id');
    }

    public function countriesRelation()
    {
        return $this->belongsTo('App\Models\Country',
             'billing_address_country',
             'id');
    }
    public function citiesRelation()
    {
        return $this->belongsTo('App\Models\City',
             'billing_address_city',
             'id');
    }


    public function spaceIdRelation()
    {
        return $this-> belongsTo('App\Models\Spaces',
             'space_id',
             'id');
    }




}
