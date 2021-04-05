<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * App\Models\Teams
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $space_id
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Teams newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teams newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teams query()
 * @method static \Illuminate\Database\Eloquent\Builder|Teams whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teams whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teams whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teams whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teams whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teams whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Teams extends BaseModel {
    protected $table                = 'teams';
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



}
