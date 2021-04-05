<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Stock
 *
 * @property int $id
 * @property string $name
 * @property string $date
 * @property string|null $weight_ceramics
 * @property string|null $analysis_pt
 * @property string|null $analysis_pd
 * @property string|null $analysis_rh
 * @property string|null $weight_dust
 * @property string|null $analysis_dust_pt
 * @property string|null $analysis_dust_pd
 * @property string|null $analysis_dust_rh
 * @property string|null $metallic
 * @property int|null $catalyst
 * @property int $user_id
 * @property int $space_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $userRelation
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock query()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereAnalysisDustPd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereAnalysisDustPt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereAnalysisDustRh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereAnalysisPd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereAnalysisPt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereAnalysisRh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereCatalyst($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereMetallic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereSpaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereWeightCeramics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereWeightDust($value)
 * @mixin \Eloquent
 * @property string|null $pt_purchase
 * @property string|null $pd_purchase
 * @property string|null $rh_purchase
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Purchase[] $purchases
 * @property-read int|null $purchases_count
 * @method static Builder|BaseModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock wherePdPurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock wherePtPurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereRhPurchase($value)
 * @property string|null $analysis
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereAnalysis($value)
 * @property string|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereOwner($value)
 */
class Stock extends BaseModel
{
    use HasFactory;

    protected $table = 'stock';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $hidden = ['deleted_at'];
    protected $dates  = ['deleted_at'];
    protected $casts  = [
        'weight_ceramics'  => 'decimal:3',
        'analysis_pt'      => 'decimal:3',
        'analysis_pd'      => 'decimal:3',
        'analysis_rh'      => 'decimal:3',
        'weight_dust'      => 'decimal:3',
        'analysis_dust_pt' => 'decimal:3',
        'analysis_dust_pd' => 'decimal:3',
        'analysis_dust_rh' => 'decimal:3',
        'metallic'         => 'decimal:3',
        'pt_purchase'      => 'decimal:3',
        'pd_purchase'      => 'decimal:3',
        'rh_purchase'      => 'decimal:3',
    ];


    public function getOwner(): string
    {
        if ($this->owner && $this->user_id) {
            $info = $this->owner::find($this->user_id);
            if ($info) {
                if ($this->owner === Clients::class) {
                    return '<a href="'.route('stock.index', ['owner' => $this->user_id]).'">'.$info->name.'</a>';
                }

                return '<a href="'.route('stock.index', ['owner' => $this->user_id]).'">'.$info->fullname().'</a>';
            }
            return '';
        }
        return '';
    }

    public static function index($params = [], $checkTimeOnly = false)
    {
        $data     = null;
        $fields   = ['id', 'title'];
        $instance = new static;

        if (!$checkTimeOnly) {
            $data = $instance->get($fields)->keyBy('id');
        }

        $r             = $instance->latest()->first();
        $indexLastTime = empty($r->updated_at) ? strtotime($r->created_at) : strtotime($r->updated_at);
        return [
            'data'        => $data,
            'filters'     => '',
            'params'      => $params,
            'server_time' => $indexLastTime
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function userRelation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,
            'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function purchases(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Purchase::class,
            StockHasPurchases::class,
            'stock_id',
            'purchase_id');
    }


}
