<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Purchase
 *
 * @package App\Models
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalog[] $catalogs
 * @property-read int|null $catalogs_count
 * @property-read \App\Models\Lots $lot
 * @property-read \App\Models\Spaces $spaces
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $pt_discount
 * @property string|null $pd_discount
 * @property string|null $rh_discount
 * @property int $lot_id
 * @property int $space_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereLotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase wherePdDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase wherePtDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereRhDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereUpdatedAt($value)
 * @property mixed|null $pt
 * @property mixed|null $pd
 * @property mixed|null $rh
 * @property string|null $weight
 * @property mixed|null $total
 * @property int|null $status_id
 * @property-read array $categories
 * @property-read \App\Models\PurchaseStatus $status
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase wherePd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase wherePt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereRh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereWeight($value)
 * @property int|null $client_id
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereClientId($value)
 * @property int|null $user_id
 * @property int|null $type_payment
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereTypePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereUserId($value)
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @property-read \App\Models\User|null $owner
 * @property string $paid
 * @property int|null $user_paid_id
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereUserPaidId($value)
 * @property string|null $paid_card
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase wherePaidCard($value)
 */
class Purchase extends BaseModel
{
    public const DISCOUNT_TYPE_MONEY   = 'money';
    public const DISCOUNT_TYPE_PERCENT = 'percent';
    public const CREATED_AT            = 'created_at';
    public const UPDATED_AT            = 'updated_at';
    protected $hidden = ['deleted_at'];
    protected $dates  = ['deleted_at'];
    protected $table  = 'purchase';
    protected $casts  = [
        'pt'    => 'decimal:3',
        'pd'    => 'decimal:3',
        'rh'    => 'decimal:3',
        'total' => 'decimal:3',
        'paid_card' => 'decimal:2',
    ];


    /**
     * @return BelongsTo
     */
    public function spaces(): BelongsTo
    {
        return $this->belongsTo(Spaces::class,
            'space_id',
            'id');
    }

    /**
     * @return BelongsTo
     */
    public function lot(): BelongsTo
    {
        return $this->belongsTo(Lots::class,
            'lot_id',
            'id');
    }

    /**
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(PurchaseStatus::class,
            'status_id',
            'id');
    }

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class,
            'user_id',
            'id');
    }

    /**
     * @return BelongsToMany
     */
    public function catalogs(): BelongsToMany
    {
        return $this->belongsToMany(Catalog::class,
            PurchaseCatalog::class,
            'purchase_id', 'catalog_id')
            ->withPivot(
                'discount',
                'discount_type',
                'count',
            );
    }


    /**
     * @param  array  $catalogIds
     * @param  int  $lotId
     * @return bool
     */
    public static function checkLots(array $catalogIds, int $lotId): bool
    {
        $catalogValues = Catalog::calcCategoriesMetal($catalogIds);
        $lot           = Lots::find($lotId);
        if ($lot) {
            return ($catalogValues['pt'] + $lot->pt_weight_used) <= $lot->pt_weight &&
                ($catalogValues['pd'] + $lot->pd_weight_used) <= $lot->pd_weight &&
                ($catalogValues['rh'] + $lot->rh_weight_used) <= $lot->rh_weight;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getCategoriesAttribute(): array
    {
        $result = [];
        foreach ($this->catalogs as $catalog) {
            $result[] = $catalog->id;
        }
        return $result;
    }

    /**
     * @param $request
     * @param $lots
     * @param $discount
     * @return float|int
     */
    public static function countTotal($price, $discount)
    {
        return $price * $discount;
    }
}