<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\RoleHasPermissions
 *
 * @property int|null $permission_id
 * @property int|null $role_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $id
 * @property-read \App\Models\Permissions|null $permission
 * @method static \Illuminate\Database\Query\Builder|RoleHasPermissions onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions whereId($value)
 * @method static \Illuminate\Database\Query\Builder|RoleHasPermissions withTrashed()
 * @method static \Illuminate\Database\Query\Builder|RoleHasPermissions withoutTrashed()
 */
class RoleHasPermissions extends Pivot
{
    use softDeletes;
    protected $table = 'role_has_permissions';
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function permission(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Permissions::class,
            'permission_id',
            'id');
    }


}
