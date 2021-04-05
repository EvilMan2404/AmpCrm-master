<?php

namespace App\Models;

/**
 * App\Models\Spaces
 *
 * @property int $id
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Spaces newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Spaces newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Spaces query()
 * @method static \Illuminate\Database\Eloquent\Builder|Spaces whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spaces whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spaces whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spaces whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spaces whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SpaceHasRole[] $hasRoles
 * @property-read int|null $has_roles_count
 */
class Spaces extends BaseModel
{
    protected $table = 'spaces';
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

    public function hasRoles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\SpaceHasRole::class, 'space_id', 'id');
    }


}
