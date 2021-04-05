<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Session;

/**
 * App\Models\Catalog
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $description
 * @property string|null $serial_number
 * @property string|null $car_brand
 * @property string|null $pt
 * @property string|null $pd
 * @property string|null $rh
 * @property string|null $weight
 * @property int|null $space_id
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereCarBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog wherePd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog wherePt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereRh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereWeight($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Files[] $files
 * @property-read int|null $files_count
 * @property-read \App\Models\CarBrand|null $carIdRelation
 * @property-read string $list_files
 * @property-read \App\Models\Spaces|null $spaceIdRelation
 * @property int|null $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereUserId($value)
 * @property int|null $user_id_edited
 * @method static \Illuminate\Database\Eloquent\Builder|Catalog whereUserIdEdited($value)
 * @property-read \App\Models\User|null $editor
 */
class Catalog extends BaseModel
{
    protected $table = 'catalog';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $hidden  = ['deleted_at'];
    protected $dates   = ['deleted_at'];
    protected $casts   = [
        'pt'     => 'decimal:3',
        'pd'     => 'decimal:3',
        'rh'     => 'decimal:3',
        'weight' => 'decimal:3',
    ];
    protected $appends = [];


    /**
     * @return string
     */
    public function getListFilesAttribute(): string
    {
        $list = [];
        foreach ($this->files as $file) {
            $list[] = $file->id;
        }
        return implode(',', $list);
    }

    /**
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany(
            Files::class,
            'model'
        );
    }

    /**
     * @param  Lots  $lot
     * @param  Discount  $discount
     * @param  array  $custom
     * @param  null  $totalDiscount
     * @return float|int
     */
    public function getPrice(Lots $lot, Discount $discount, array $custom = [], $totalDiscount = null)
    {
        $item = $custom[$this->id] ?? null;
        if ($lot->id === null && Session::has([
                'pt',
                'pd',
                'rh',
                'd_pt',
                'd_pd',
                'd_rh',
            ])) {
            $lot->pt_rate          = (float) Session::get('pt');
            $lot->pd_rate          = (float) Session::get('pd');
            $lot->rh_rate          = (float) Session::get('rh');
            $discount->pt_discount = (int) Session::get('d_pt');
            $discount->pd_discount = (int) Session::get('d_pd');
            $discount->rh_discount = (int) Session::get('d_rh');
        }
        if ($item === null) {
            $calc = (($this->weight * $this->pt * 10 * $lot->pt_rate) * ($discount->pt_discount / 100)) +
                (($this->weight * $this->pd * 10 * $lot->pd_rate) * ($discount->pd_discount / 100)) +
                (($this->weight * $this->rh * 10 * $lot->rh_rate) * ($discount->rh_discount / 100));
            $calc = $totalDiscount !== null ? $calc * ($totalDiscount / 100) : $calc;
            return round($calc, 3);
        }
        if (($item['discount_type'] ?? null) === Purchase::DISCOUNT_TYPE_MONEY) {
            $calc = (float) $item['discount'] * (int) $item['count'];
            $calc = $totalDiscount !== null ? $calc * ($totalDiscount / 100) : $calc;

            return round($calc, 3);
        }
        $calc = (((($this->weight * $this->pt * 10 * $lot->pt_rate) * (int) $item['count']) * ($discount->pt_discount / 100)) +
                ((($this->weight * $this->pd * 10 * $lot->pd_rate) * (int) $item['count']) * ($discount->pd_discount / 100)) +
                ((($this->weight * $this->rh * 10 * $lot->rh_rate) * (int) $item['count']) * ($discount->rh_discount / 100))) *
            ((int) $item['discount'] / 100);
        $calc = $totalDiscount !== null ? $calc * ($totalDiscount / 100) : $calc;
        return round($calc, 3);
    }

    /**
     * @return BelongsTo
     */
    public function spaceIdRelation(): BelongsTo
    {
        return $this->belongsTo(Spaces::class,
            'space_id',
            'id');
    }

    /**
     * @return BelongsTo
     */
    public function carIdRelation(): BelongsTo
    {
        return $this->belongsTo(CarBrand::class,
            'car_brand',
            'id');
    }

    /**
     * @return BelongsTo
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class,
            'user_id_edited',
            'id');
    }

    /**
     * @param  array  $ids
     * @param  Lots|null  $lot
     * @param  Discount|null  $discount
     * @param  array  $custom
     * @return int[]
     */
    public static function calcCategoriesMetal(
        array $ids,
        Lots $lot = null,
        Discount $discount = null,
        array $custom = []
    ): array {
        $result = [
            'pt'     => 0,
            'pd'     => 0,
            'rh'     => 0,
            'weight' => 0,
            'price'  => 0,
        ];

        $values = self::getListWhereIdIn($ids);
        foreach ($values as $value) {
            $result['pt']     += $value->pt;
            $result['pd']     += $value->pd;
            $result['rh']     += $value->rh;
            $result['weight'] += $value->weight;
            if ($lot && $discount) {
                $result['price'] += $value->getPrice($lot, $discount, $custom);
            }
        }
        return $result;
    }

}
