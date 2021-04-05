<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * App\Models\Operations
 *
 * @property int $id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $inbox_finance
 * @property string|null $outbox_finance
 * @property string|null $total_amount
 * @property int|null $space_id
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Operations newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Operations newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Operations query()
 * @method static \Illuminate\Database\Eloquent\Builder|Operations whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operations whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operations whereInboxFinance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operations whereOutboxFinance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operations whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operations whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operations whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operations whereUserId($value)
 * @mixin \Eloquent
 */
class Operations extends BaseModel {
    protected $table                = 'operations';
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
             'id');
    }



}
