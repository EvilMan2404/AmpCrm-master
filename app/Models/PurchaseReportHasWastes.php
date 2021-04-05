<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PurchaseReportHasWastes
 *
 * @property int $id
 * @property int|null $waste_id
 * @property int|null $report_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasWastes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasWastes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasWastes query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasWastes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasWastes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasWastes whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasWastes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasWastes whereWasteId($value)
 * @mixin \Eloquent
 * @property string|null $sum
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasWastes whereSum($value)
 * @property-read \App\Models\WasteTypes|null $waste
 */
class PurchaseReportHasWastes extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function waste(): BelongsTo
    {
        return $this->belongsTo(WasteTypes::class, 'waste_id', 'id');
    }
}
