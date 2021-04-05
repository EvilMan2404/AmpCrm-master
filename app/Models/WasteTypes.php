<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\WasteTypes
 *
 * @property int $id
 * @property string $name
 * @property int $space_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|WasteTypes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WasteTypes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WasteTypes query()
 * @method static \Illuminate\Database\Eloquent\Builder|WasteTypes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WasteTypes whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WasteTypes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WasteTypes whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WasteTypes whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WasteTypes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WasteTypes extends BaseModel
{
    use HasFactory;
}
