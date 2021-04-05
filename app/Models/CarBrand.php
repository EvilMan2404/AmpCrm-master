<?php

namespace App\Models;


/**
 * App\Models\CarBrand
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $space_id
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|CarBrand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarBrand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarBrand query()
 * @method static \Illuminate\Database\Eloquent\Builder|CarBrand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarBrand whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarBrand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarBrand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarBrand whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarBrand whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Catalog $catalogRelation
 * @property-read \App\Models\Spaces|null $spaceIdRelation
 */
class CarBrand extends BaseModel
{
    protected $table = 'car_brand';
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


    public function spaceIdRelation()
    {
        return $this->belongsTo('App\Models\Spaces',
            'space_id',
            'id');
    }

    public function catalogRelation()
    {
        return $this->belongsTo(Catalog::class,
            'id',
            'car_brand');
    }


}
