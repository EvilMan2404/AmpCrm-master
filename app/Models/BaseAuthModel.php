<?php

namespace App\Models;
use App\Models\CheckPerm;
use Illuminate\Support\Facades\File;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\BaseAuthModel
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|BaseAuthModel filter(\App\Models\QueryFilter $filters)
 * @method static Builder|BaseAuthModel newModelQuery()
 * @method static Builder|BaseAuthModel newQuery()
 * @method static Builder|BaseAuthModel query()
 * @mixin \Eloquent
 */
class BaseAuthModel extends Authenticatable
{
    use Notifiable;


    public static $cacheKeys = [];

    CONST FILE_AR = [];
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public $guarded = [];
    protected $table = null;
    protected $primaryKey = 'id';
    const PK = 'id';
    const ORDER_COLUMN = null;

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }

    /**
     * Restore a soft-deleted model instance.
     *
     * @return bool|null
     */
    public function restore()
    {
        // If the restoring event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($this->fireModelEvent('restoring') === false) {
            return false;
        }

        $this->{$this->getDeletedAtColumn()} = null;

        // Once we have saved the model, we will fire the "restored" event so this
        // developer will do anything they need to after a restore operation is
        // totally finished. Then we will return the result of the save call.
        $this->exists = true;

        $result = $this->save();

        $this->fireModelEvent('restored', false);

        return $result;
    }

    public static function getLatestTime($instance) {
        $indexLastTime = $instance->latest()->first();
        return empty($indexLastTime->updated_at)?(empty($indexLastTime->created_at)?0:strtotime($indexLastTime->created_at)):strtotime($indexLastTime->updated_at);
    }

    public static function deleteMass($arOfIds = [])
    {
        foreach ($arOfIds as $id) {
            static::deleteOne($id);
        }
    }

    public static function restoreMass($arOfIds = [])
    {
        foreach ($arOfIds as $id) {
            static::restoreOne($id);
        }
    }

    public static function fullDeleteMass($arOfIds = [])
    {
        foreach ($arOfIds as $id) {
            $row = static::getRowOnlyTrashed($id);
            foreach (static::FILE_AR as $mainField => $anotherFields) {
                static::emptyField($id, $mainField, false);
            }
            $row->forceDelete();
        }
    }

    public static function getListUsed($whereCondition = [], $fieldName, $orWhereInAr = [])
    {
        $result = static::withTrashed()->where($whereCondition);
        if (!empty($orWhereInAr)) {
            $result = $result->orWhereIn(static::PK, $orWhereInAr);
        }
        $result = $result->get()->pluck($fieldName)->toArray();

        return $result;
    }

    public static function getListWhereIdNotIn($usedListId = [], $whereInAr = [], $withIdAr = [])
    {
        $result = static::where($whereInAr);

        if (!empty($usedListId)) {
            $result = $result->whereNotIn(static::PK, $usedListId);
        }

        if (!empty($withIdAr)) {
            $result = $result->orWhereIn(static::PK, $withIdAr);
        }

        $result = $result->get();

        return $result;
    }

    public static function getListWhereIdIn($usedListId = [])
    {
        $result = static::whereIn(static::primaryKey, $usedListId)->get();

        return $result;
    }

    public static function getList($perPage = null)
    {
        return ($perPage == null) ? static::all() : static::paginate($perPage);
    }

    public static function getAnyList($deleted = false, $perPage = null)
    {
        if ($deleted) {
            return static::getListOnlyTrashed($perPage);
        } else {
            return static::getList($perPage);
        }

    }

    public static function getListOnlyTrashed($perPage = null)
    {
        return ($perPage == null) ? static::onlyTrashed()->get() : static::onlyTrashed()->paginate($perPage);
    }

    public static function getListWithTrashed($perPage = null)
    {
        return ($perPage == null) ? static::withTrashed()->get() : static::withTrashed()->paginate($perPage);
    }

    public static function getRow($id)
    {
        return static::findOrFail($id);
    }

    public static function getRowWithTrashed($id)
    {
        return static::withTrashed()->findOrFail($id);
    }

    public static function getRowOnlyTrashed($id)
    {
        return static::onlyTrashed()->findOrFail($id);
    }

    public static function emptyField($id, $fieldName, $updateRow = true)
    {
        if (isset(static::FILE_AR[$fieldName])) {
            $row = static::withTrashed()->findOrFail($id);
            $clearFields = [$fieldName => null];

            if (!empty($row[$fieldName])) {
                File::delete(public_path($row[$fieldName]));
            }

            if (is_array(static::FILE_AR[$fieldName])) {
                foreach (static::FILE_AR[$fieldName] as $field) {
                    $clearFields[$field] = null;
                    if (!empty($row[$field])) {
                        File::delete(public_path($row[$field]));
                    }
                }
            }
            if ($updateRow) {
                $row->update($clearFields);
            }
        }
    }

    public static function boot()
    {
        static::creating(
            function ($model) {
                if (!empty(static::ORDER_COLUMN)) {
                    $model[static::ORDER_COLUMN] = 0;
                }
                static::onCreateOrUpdateEvent($model);
            }
        );

        static::updating(
            function ($model) {
                static::onCreateOrUpdateEvent($model);

            }
        );


        parent::boot();


        static::created(
            function ($model) {
                if (!empty(static::ORDER_COLUMN)) {
                    static::moveOrder($model->id, -1);
                }
            }
        );

    }

    public static function deleteOne($id)
    {
        $result = [];
        if (!empty(static::ORDER_COLUMN)) {
            static::moveOrder(0, $id);
            static::withTrashed()->findOrFail($id)->update([static::ORDER_COLUMN => 0]);
        }

        $result['delete'] = static::withTrashed()->findOrFail($id)->delete();

        return $result;
    }

    public static function restoreOne($id)
    {
        static::moveOrder($id, -1);

        static::withTrashed()->findOrFail($id)->restore();
        //Brands::onlyTrashed()->whereIN('id', array_values($request->mass))->restore();
    }


    public static function moveOrder($thisId, $idThatBefore = 0, $additionalWhere = [])
    {
        if (empty(static::ORDER_COLUMN)) {
            return false;
        }
        if ($thisId == 0) {
            //elemets will be deleted
            $numericalOrder_idThatBefore = static::withTrashed()->findOrFail(
                $idThatBefore
            )[static::ORDER_COLUMN];

            static::where(
                array_merge(
                    [
                        [static::ORDER_COLUMN, '>', $numericalOrder_idThatBefore],
                    ],
                    $additionalWhere
                )
            )->decrement(static::ORDER_COLUMN);

        } else {
            $numericalOrder_thisId = static::withTrashed()->findOrFail($thisId)[static::ORDER_COLUMN];

            if ($idThatBefore == 0) { //Якшо якийсь елемент ставиться на перший

                static::where(
                    array_merge(
                        [
                            [static::ORDER_COLUMN, '<', $numericalOrder_thisId],
                        ],
                        $additionalWhere
                    )
                )->increment(static::ORDER_COLUMN);
                static::withTrashed()->findOrFail($thisId)->update([static::ORDER_COLUMN => 0]);

            } elseif ($idThatBefore == -1) {
                static::where(
                    array_merge(
                        [
                            [static::ORDER_COLUMN, '>', -1],
                        ],
                        $additionalWhere
                    )
                )->increment(static::ORDER_COLUMN);
                static::withTrashed()->findOrFail($thisId)->update([static::ORDER_COLUMN => 0]);
            } else {
                $numericalOrder_idThatBefore = static::withTrashed()->findOrFail(
                    $idThatBefore
                )[static::ORDER_COLUMN];
                if ($numericalOrder_thisId > $numericalOrder_idThatBefore) { //up
                    static::where(
                        array_merge(
                            [
                                [static::ORDER_COLUMN, '>', $numericalOrder_idThatBefore],
                                [static::ORDER_COLUMN, '<', $numericalOrder_thisId],
                            ],
                            $additionalWhere
                        )
                    )->increment(static::ORDER_COLUMN);
                    static::withTrashed()->findOrFail($thisId)->update(
                        [static::ORDER_COLUMN => $numericalOrder_idThatBefore + 1]
                    );
                } elseif ($numericalOrder_thisId < $numericalOrder_idThatBefore) { //down

                    static::where(
                        array_merge(
                            [
                                [static::ORDER_COLUMN, '<=', $numericalOrder_idThatBefore],
                                [static::ORDER_COLUMN, '>', $numericalOrder_thisId],
                            ],
                            $additionalWhere
                        )
                    )->decrement(static::ORDER_COLUMN);
                    static::withTrashed()->findOrFail($thisId)->update(
                        [static::ORDER_COLUMN => $numericalOrder_idThatBefore]
                    );

                }
            }
        }

        return true;
    }
}
