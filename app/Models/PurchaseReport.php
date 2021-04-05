<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\PurchaseReport
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $history
 * @property string|null $total_lots
 * @property string|null $total_waste
 * @property string|null $total
 * @property int|null $user_id
 * @property int $space_id
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport whereHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport whereTotalLots($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport whereTotalWaste($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport whereUserId($value)
 * @property string|null $date_start
 * @property string|null $date_finish
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stock[] $stocks
 * @property-read int|null $stocks_count
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport whereDateFinish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReport whereDateStart($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PurchaseReportHasWastes[] $hasWastes
 * @property-read int|null $has_wastes_count
 * @property-read \App\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stock[] $wasteTypes
 * @property-read int|null $waste_types_count
 */
class PurchaseReport extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stocks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Stock::class,
            PurchaseReportHasLots::class,
            'report_id',
            'stock_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wasteTypes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Stock::class,
            PurchaseReportHasWastes::class,
            'report_id',
            'waste_id');
    }

    /**
     * @return HasMany
     */
    public function hasWastes(): HasMany
    {
        return $this->hasMany(PurchaseReportHasWastes::class, 'report_id', 'id');
    }

    /**
     * @return array
     */
    public function hasWastesArray(): array
    {
        $array = array();
        foreach ($this->hasWastes as $value) {
            $array[] = $value->waste_id;
        }
        return $array;
    }

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return array
     */
    public static function getPreviousWeek(): array
    {
        $now               = Carbon::now();
        $weekStartDate     = $now->startOfWeek()->subDays(7)->format('Y-m-d');
        $weekEndDate       = $now->endOfWeek()->format('Y-m-d');
        $lastweek['start'] = $weekStartDate;
        $lastweek['end']   = $weekEndDate;
        return $lastweek;
    }
}
