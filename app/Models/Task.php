<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Task
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $status_id
 * @property string $date_start
 * @property string $date_end
 * @property string $source
 * @property int $source_id
 * @property int|null $priority_id
 * @property int|null $user_id
 * @property int|null $assigned_user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereAssignedUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Task onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Task withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Task withoutTrashed()
 * @property int $space_id
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereSpaceId($value)
 * @property-read \App\Models\User|null $assignedRelation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Files[] $files
 * @property-read int|null $files_count
 * @property-read \App\Models\TasksPriorities|null $priorityRelation
 * @property-read \App\Models\TasksStatuses|null $statusRelation
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 */
class Task extends BaseModel
{
    use HasFactory;

    public const MODEL_TYPE_LIST = [
        Purchase::class => 'Закупка',
        Clients::class  => 'Клиенты',
        Catalog::class  => 'Каталог',
        Company::class  => 'Компания фиксирующая курс',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function statusRelation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TasksStatuses::class,
            'status_id',
            'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priorityRelation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TasksPriorities::class,
            'priority_id',
            'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedRelation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,
            'assigned_user',
            'id');
    }

    /**
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany(
            Files::class,
            'model'
        );
    }

    /**
     * @return string
     */
    public function dateStart(): string
    {
        return Carbon::parse($this->date_start)->format('Y-m-d\TH:i');
    }

    /**
     * @return string
     */
    public function dateEnd(): string
    {
        return Carbon::parse($this->date_end)->format('Y-m-d\TH:i');
    }
}
