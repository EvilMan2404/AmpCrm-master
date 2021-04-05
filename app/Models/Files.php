<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * App\Models\Files
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $file
 * @property string|null $ext
 * @property int|null $size
 * @property string|null $model_type
 * @property string|null $model_id
 * @property int|null $space_id
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Files newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Files newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Files query()
 * @method static \Illuminate\Database\Eloquent\Builder|Files whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files whereExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Files extends BaseModel {
    protected $table                = 'files';
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



}
