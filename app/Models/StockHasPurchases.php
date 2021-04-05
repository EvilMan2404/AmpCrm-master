<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StockHasPurchases
 *
 * @property int $id
 * @property int|null $stock_id
 * @property int|null $purchase_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StockHasPurchases newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockHasPurchases newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockHasPurchases query()
 * @method static \Illuminate\Database\Eloquent\Builder|StockHasPurchases whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHasPurchases whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHasPurchases whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHasPurchases wherePurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHasPurchases whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockHasPurchases whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StockHasPurchases extends Model
{
    use HasFactory;
}
