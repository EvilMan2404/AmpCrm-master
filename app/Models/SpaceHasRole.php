<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * App\Models\SpaceHasRole
 *
 * @property int|null $space_id
 * @property int|null $role_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceHasRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceHasRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceHasRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceHasRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceHasRole whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceHasRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceHasRole whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceHasRole whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|SpaceHasRole whereId($value)
 * @property-read \App\Models\Roles|null $roleIdRelation
 */
class SpaceHasRole extends BaseModel {
    protected $table                = 'space_has_role';
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


    public function spaceIdRelation()
    {
        return $this-> belongsTo('App\Models\Spaces',
             'space_id',
             'id');
    }


    public function roleIdRelation()
    {
        return $this->belongsTo('App\Models\Roles',
             'role_id',
             'id');
    }



}
