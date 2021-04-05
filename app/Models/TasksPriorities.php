<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\TasksPriorities
 *
 * @property int $id
 * @property string $name
 * @property string $text_color
 * @property string $background_color
 * @property int $space_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TasksPriorities newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TasksPriorities newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TasksPriorities query()
 * @method static \Illuminate\Database\Eloquent\Builder|TasksPriorities whereBackgroundColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TasksPriorities whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TasksPriorities whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TasksPriorities whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TasksPriorities whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TasksPriorities whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TasksPriorities whereTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TasksPriorities whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|TasksPriorities onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|TasksPriorities withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TasksPriorities withoutTrashed()
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 */
class TasksPriorities extends BaseModel
{
    use HasFactory;
}
