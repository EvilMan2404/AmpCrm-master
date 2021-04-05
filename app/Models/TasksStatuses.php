<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\TasksStatuses
 *
 * @property int $id
 * @property string $name
 * @property int $space_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TasksStatuses newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TasksStatuses newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TasksStatuses query()
 * @method static \Illuminate\Database\Eloquent\Builder|TasksStatuses whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TasksStatuses whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TasksStatuses whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TasksStatuses whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TasksStatuses whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TasksStatuses whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|TasksStatuses onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|TasksStatuses withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TasksStatuses withoutTrashed()
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 */
class TasksStatuses extends BaseModel
{
    use HasFactory;
}
