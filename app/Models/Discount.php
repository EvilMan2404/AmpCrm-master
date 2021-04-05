<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Discount
 *
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount query()
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $pt_discount
 * @property string|null $pd_discount
 * @property string|null $rh_discount
 * @property int|null $purchase_discount
 * @property int $space_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount wherePdDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount wherePtDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount wherePurchaseDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereRhDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereUpdatedAt($value)
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 */
class Discount extends BaseModel
{
    protected $table      = 'discount';
    protected $casts      = [
        'pt_discount'       => 'integer',
        'pd_discount'       => 'integer',
        'rh_discount'       => 'integer',
        'purchase_discount' => 'integer',
        'space_id'          => 'integer',
    ];
    protected $attributes = [
        'pt_discount'       => 100,
        'pd_discount'       => 100,
        'rh_discount'       => 100,
        'purchase_discount' => 100,
    ];
    protected $fillable   = [
        'pt_discount', 'pd_discount', 'rh_discount', 'purchase_discount','space_id'
    ];

    
}