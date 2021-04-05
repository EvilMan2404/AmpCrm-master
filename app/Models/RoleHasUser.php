<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * App\Models\RoleHasUser
 *
 * @property int|null $user_id
 * @property int|null $role_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasUser whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasUser whereUserId($value)
 * @mixin \Eloquent
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasUser whereId($value)
 */
class RoleHasUser extends BaseModel {
    protected $table                = 'role_has_user';
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


    public function roleIdRelation()
    {
        return $this-> belongsTo(Roles::class,
             'role_id',
             'id');
    }



}
