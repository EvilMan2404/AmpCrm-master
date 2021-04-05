<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Lots
 *
 * @property int $id
 * @property string|null $company_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property int|null $user_id
 * @property string|null $pt_weight
 * @property string|null $pd_weight
 * @property string|null $pt_rate
 * @property string|null $rh_weight
 * @property string|null $pd_rate
 * @property string|null $rh_rate
 * @property int|null $space_id
 * @method static Builder|BaseModel filter(QueryFilter $filters)
 * @method static Builder|Lots newModelQuery()
 * @method static Builder|Lots newQuery()
 * @method static Builder|Lots query()
 * @method static Builder|Lots whereCompanyId($value)
 * @method static Builder|Lots whereCreatedAt($value)
 * @method static Builder|Lots whereDeletedAt($value)
 * @method static Builder|Lots whereId($value)
 * @method static Builder|Lots wherePdRate($value)
 * @method static Builder|Lots wherePdWeight($value)
 * @method static Builder|Lots wherePtRate($value)
 * @method static Builder|Lots wherePtWeight($value)
 * @method static Builder|Lots whereRhRate($value)
 * @method static Builder|Lots whereRhWeight($value)
 * @method static Builder|Lots whereSpaceId($value)
 * @method static Builder|Lots whereUpdatedAt($value)
 * @method static Builder|Lots whereUserId($value)
 * @mixin Eloquent
 * @property int $assigned_user
 * @property string|null $pt_weight_used
 * @property string|null $pd_weight_used
 * @property string|null $rh_weight_used
 * @method static Builder|Lots whereAssignedUser($value)
 * @method static Builder|Lots wherePdWeightUsed($value)
 * @method static Builder|Lots wherePtWeightUsed($value)
 * @method static Builder|Lots whereRhWeightUsed($value)
 * @property string|null $name
 * @property string|null $description
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User $owner
 * @property-read \App\Models\User|null $space
 * @property-read \App\Models\User|null $user
 * @method static Builder|Lots whereDescription($value)
 * @method static Builder|Lots whereName($value)
 * @property-read \App\Models\User $assigned
 */
class Lots extends BaseModel
{
    protected $table = 'lots';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $hidden = ['deleted_at'];
    protected $dates  = ['deleted_at'];

    protected $appends = [];

    protected $casts = [
        'pt_weight'          => 'decimal:3',
        'pd_weight'          => 'decimal:3',
        'pt_rate'            => 'decimal:3',
        'rh_weight'          => 'decimal:3',
        'pd_rate'            => 'decimal:3',
        'rh_rate'            => 'decimal:3',
        'pt_weight_used'     => 'decimal:3',
        'pd_weight_used'     => 'decimal:3',
        '	rh_weight_used' => 'decimal:3',
    ];

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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class,
            'company_id',
            'id');
    }


    public function space(): BelongsTo
    {
        return $this->belongsTo(User::class,
            'space_id',
            'id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class,
            'user_id',
            'id');
    }

    public function assigned(): BelongsTo
    {
        return $this->belongsTo(User::class,
            'assigned_user',
            'id');
    }


}
