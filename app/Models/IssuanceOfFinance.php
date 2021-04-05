<?php

namespace App\Models;

/**
 * App\Models\IssuanceOfFinance
 *
 * @property int $id
 * @property int|null $assigned_user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id
 * @property string|null $amount
 * @property string|null $balance
 * @property string|null $name
 * @property string|null $description
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|IssuanceOfFinance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IssuanceOfFinance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IssuanceOfFinance query()
 * @method static \Illuminate\Database\Eloquent\Builder|IssuanceOfFinance whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IssuanceOfFinance whereAssignedUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IssuanceOfFinance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IssuanceOfFinance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IssuanceOfFinance whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IssuanceOfFinance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IssuanceOfFinance whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IssuanceOfFinance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IssuanceOfFinance whereUserId($value)
 * @mixin \Eloquent
 * @property int $space_id
 * @method static \Illuminate\Database\Eloquent\Builder|IssuanceOfFinance whereSpaceId($value)
 * @property-read \App\Models\User|null $assignedUserRelation
 * @property-read \App\Models\User|null $userIdRelation
 * @method static \Illuminate\Database\Eloquent\Builder|IssuanceOfFinance whereBalance($value)
 */
class IssuanceOfFinance extends BaseModel
{
    protected $table = 'issuance_of_finance';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
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


    public static function index($params = [], $checkTimeOnly = false)
    {
        $data     = null;
        $fields   = ['id', 'title'];
        $instance = new static;

        if (!$checkTimeOnly) {
            $data = $instance->get($fields)->keyBy('id');
        }

        $r             = $instance->latest()->first();
        $indexLastTime = empty($r->updated_at) ? strtotime($r->created_at) : strtotime($r->updated_at);
        return [
            'data'        => $data,
            'filters'     => '',
            'params'      => $params,
            'server_time' => $indexLastTime
        ];
    }


    public function assignedUserRelation()
    {
        return $this->belongsTo(\App\Models\User::class,
            'assigned_user',
            'id');
    }


    public function userIdRelation()
    {
        return $this->belongsTo(\App\Models\User::class,
            'user_id',
            'id');
    }


}
