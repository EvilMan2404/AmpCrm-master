<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * App\Models\Actions
 *
 * @property int $id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $description
 * @property string|null $model_type
 * @property string|null $model_id
 * @property int|null $space_id
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Actions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Actions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Actions query()
 * @method static \Illuminate\Database\Eloquent\Builder|Actions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Actions whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Actions whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Actions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Actions whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Actions whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Actions whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Actions whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Actions whereUserId($value)
 * @mixin \Eloquent
 */
class Actions extends BaseModel {
    protected $table                = 'actions';
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


    public function userIdRelation()
    {
        return $this-> belongsTo('App\Models\User',
             'user_id',
             'id');
    }


    public function spaceIdRelation()
    {
        return $this-> belongsTo('App\Models\Spaces',
             'space_id',
             'title');
    }



}
