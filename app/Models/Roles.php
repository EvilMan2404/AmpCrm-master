<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Roles
 *
 * @property int|null $id
 * @property string|null $name
 * @property string|null $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Roles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Roles query()
 * @method static \Illuminate\Database\Eloquent\Builder|Roles whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\RoleHasPermissions|null $idRelation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RoleHasUser[] $hasUsers
 * @property-read int|null $has_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permissions[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RoleHasPermissions[] $permissionsHas
 * @property-read int|null $permissions_has_count
 */
class Roles extends BaseModel
{
    protected $table = 'roles';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $hidden = ['deleted_at'];
    protected $dates  = ['deleted_at'];

    protected $appends = [];

    public static function onCreateOrUpdateEvent($model)
    {
    }

    /**
     *
     */
    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            /* if ($model->getOriginal('account_status_id') !== $model->attributes['account_status_id']) {
            } */
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Permissions::class,
            RoleHasPermissions::class,
            'role_id',
            'permission_id');
    }

    /**
     * @return HasMany
     */
    public function permissionsHas(): HasMany
    {
        return $this->hasMany(
            RoleHasPermissions::class,
            'role_id',
            'id');
    }

    /**
     * @return array
     */
    public function arrayPermissions(): array
    {
        $permissions = array();
        foreach ($this->permissionsHas as $permission) {
            $permissions[] = $permission->permission_id;
        }
        return $permissions;
    }

    /**
     * @return HasMany
     */
    public function hasUsers(): HasMany
    {
        return $this->hasMany(\App\Models\RoleHasUser::class, 'role_id', 'id');
    }


}
