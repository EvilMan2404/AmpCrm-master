<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use App\Models\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseModel extends Model
{
    use SoftDeletes;

    public const ORDER_COLUMN = null;
    protected $appends = [];
    public const FILE_AR = [];

    public static $cacheKeys = [];

    public static $importOptionsAr = [];

    protected $casts      = [];
    public    $guarded    = [];
    protected $table      = null;
    protected $primaryKey = 'id';
    public const PK = 'id';

    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder
    {
        return $filters->apply($builder);
    }

    public function belongsToMany(
        $related,
        $table = null,
        $foreignPivotKey = null,
        $relatedPivotKey = null,
        $parentKey = null,
        $relatedKey = null,
        $relation = null
    ): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return parent::belongsToMany($related, $table, $foreignPivotKey, $relatedPivotKey,
            $parentKey, $relatedKey, $relation)->wherePivotNull('deleted_at');
    }


    public static function getLatestTime($instance)
    {
        $indexLastTime = $instance->latest()->first();
        if (empty($indexLastTime->created_at)) {
            return empty($indexLastTime->updated_at) ? (0) : strtotime($indexLastTime->updated_at);
        }

        return empty($indexLastTime->updated_at) ? (strtotime($indexLastTime->created_at)) : strtotime($indexLastTime->updated_at);
    }

    public static function fullDeleteMass($arOfIds = []): void
    {
        foreach ($arOfIds as $id) {
            $row = static::getRowOnlyTrashed($id);
            foreach (static::FILE_AR as $mainField => $anotherFields) {
                static::emptyField($id, $mainField, false);
            }
            $row->forceDelete();
        }
    }

    public static function getListUsed($whereCondition = [], $fieldName = null, $orWhereInAr = [])
    {
        $result = static::where($whereCondition);
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
        return static::whereIn(static::PK, $usedListId)->get();
    }

    public static function getTree($id, $parentFieldName = 'parent_id', $where = [])
    {
        $instance = new static;
        if (!empty($where)) {
            $instance = $instance->where($instance);
        }
        $instance = $instance->where([$parentFieldName => $id]);
        if (!empty(static::ORDER_COLUMN)) {
            $instance = $instance->orderBy(static::ORDER_COLUMN);
        }
        $children = $instance->get()->keyBy(static::PK);
        foreach ($children as $child) {
            $child['children'] = static::getTree($child->id, $parentFieldName, $where = []);
        }
        return $children;
    }

    public static function getList($perPage = null, $where = [])
    {
        $instance = new static;
        if (!empty($where)) {
            $instance = $instance->where($instance);
        }
        if (!empty(static::ORDER_COLUMN)) {
            $instance = $instance->orderBy(static::ORDER_COLUMN);
        }
        return ($perPage === null) ? $instance->get() : $instance->paginate($perPage);
    }

    public static function getAnyList($deleted = false, $perPage = null, $where = [])
    {
        if ($deleted) {
            return static::getListOnlyTrashed($perPage, $where);
        }

        return static::getList($perPage, $where);
    }

    public static function getListOnlyTrashed($perPage = null, $where = [])
    {
        $instance = new static;
        if (!empty($where)) {
            $instance = $instance->where($instance);
        }
        return ($perPage === null) ? $instance->onlyTrashed()->get() : $instance->onlyTrashed()->paginate($perPage);
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
            $row         = static::withTrashed()->findOrFail($id);
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

    public static function onCreateOrUpdateEvent($model)
    {
    }


    public static function boot()
    {
        static::creating(function ($model) {
            if (!empty(static::ORDER_COLUMN)) {
                $model[static::ORDER_COLUMN] = 0;
            }
            static::onCreateOrUpdateEvent($model);
        });

        static::updating(function ($model) {
            static::onCreateOrUpdateEvent($model);
        });


        parent::boot();


        static::created(function ($model) {
            if (!empty(static::ORDER_COLUMN)) {
                static::moveOrder($model->id, -1);
            }
        });
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


    public static function moveOrder(
        $thisId,
        $idThatBefore = 0,
        $additionalWhere = [],
        $options = ['param_is_id' => true]
    ) {
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
                if ($options['param_is_id'] == false) {
                    $numericalOrder_idThatBefore = $idThatBefore;
                } else {
                    $numericalOrder_idThatBefore = static::withTrashed()->findOrFail(
                        $idThatBefore
                    )[static::ORDER_COLUMN];
                }
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


    public static function lockTable($table = null)
    {
        if ($table === null) {
            $table = (new static)->getTable();
        }
        $connection = \DB::connection()->getName();

        if ($connection === 'mysql') {
            $sql = "LOCK TABLES {$table} WRITE";
        }

        if ($connection === 'mssql') {
            $sql = "LOCK TABLE {$table}";
        }

        try {
            \DB::unprepared($sql);
        } catch (\Exception $e) {
            //do something
        }
    }

    public static function unlockTable($table)
    {
        if ($table === null) {
            $table = (new static)->getTable();
        }
        $connection = \DB::connection()->getName();

        if ($connection === 'mysql') {
            $sql = "unlock  TABLES {$table} ";
        }

        if ($connection === 'mssql') {
            $sql = "unlock  TABLE {$table}";
        }

        try {
            \DB::unprepared($sql);
        } catch (\Exception $e) {
            //do something
        }
    }
}
