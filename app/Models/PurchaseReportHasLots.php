<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PurchaseReportHasLots
 *
 * @property int $id
 * @property int|null $purchase_id
 * @property int|null $report_id
 * @property string|null $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasLots newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasLots newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasLots query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasLots whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasLots whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasLots wherePurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasLots whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasLots whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasLots whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $stock_id
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseReportHasLots whereStockId($value)
 */
class PurchaseReportHasLots extends Model
{
    use HasFactory;
}
