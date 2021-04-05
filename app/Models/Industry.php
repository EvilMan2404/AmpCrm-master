<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * App\Models\Industry
 *
 * @property int|null $id
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Industry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Industry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Industry query()
 * @method static \Illuminate\Database\Eloquent\Builder|Industry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Industry whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Industry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Industry whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Industry whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $space_id
 * @method static \Illuminate\Database\Eloquent\Builder|Industry whereSpaceId($value)
 */
class Industry extends BaseModel {
    protected $table                = 'industry';
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
        return $this-> belongsTo('App\Models\Clients',
             'id',
             'industry_id');
    }



}
