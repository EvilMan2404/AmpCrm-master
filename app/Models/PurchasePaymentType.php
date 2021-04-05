<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PurchasePaymentType
 *
 * @property int $id
 * @property string $name
 * @property int $space_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|PurchasePaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchasePaymentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchasePaymentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchasePaymentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchasePaymentType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchasePaymentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchasePaymentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchasePaymentType whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchasePaymentType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 */
class PurchasePaymentType extends BaseModel
{
    use HasFactory;
}
