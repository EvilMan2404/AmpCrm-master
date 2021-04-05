<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * App\Models\Permissions
 *
 * @property int|null $id
 * @property string|null $name_field
 * @property string|null $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions whereNameField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions whereName($value)
 * @property string|null $desc
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions whereDesc($value)
 */
class Permissions extends BaseModel {
    protected $table                = 'permissions';
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


    public function idRelation()
    {
        return $this-> belongsTo('App\Models\RoleHasPermissions',
             'id',
             'permission_id');
    }



}
