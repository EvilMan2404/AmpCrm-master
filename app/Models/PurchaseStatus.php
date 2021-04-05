<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PurchaseStatus
 *
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseStatus query()
 * @mixin \Eloquent
 * @property int $purchase_id
 * @property int $catalog_id
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseStatus whereCatalogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseStatus wherePurchaseId($value)
 * @property int $id
 * @property string $name
 * @property int $space_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseStatus whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseStatus whereUpdatedAt($value)
 * @property-read \App\Models\Purchase $purchaseRelation
 * @property int|null $final
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseStatus whereFinal($value)
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 */
class PurchaseStatus extends BaseModel
{
    protected $table = 'purchase_status';

    /**
     * @return BelongsTo
     */
    public function purchaseRelation(): BelongsTo
    {
        return $this->belongsTo(Purchase::class,
            'id',
            'status_id');
    }

}