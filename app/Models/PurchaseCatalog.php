<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PurchaseCatalog
 *
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseCatalog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseCatalog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseCatalog query()
 * @mixin \Eloquent
 * @property int $purchase_id
 * @property int $catalog_id
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseCatalog whereCatalogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseCatalog wherePurchaseId($value)
 * @property mixed $discount
 * @property string|null $discount_type
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseCatalog whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseCatalog whereDiscountType($value)
 * @property int $count
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseCatalog whereCount($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|PurchaseCatalog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseCatalog whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|PurchaseCatalog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PurchaseCatalog withoutTrashed()
 */
class PurchaseCatalog extends Pivot
{
    use SoftDeletes;
    protected $table = 'purchase_catalog';
    protected $casts  = [
        'discount'    => 'decimal:3',
    ];
}