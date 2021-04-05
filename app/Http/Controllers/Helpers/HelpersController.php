<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelpersController extends Controller
{
    /**
     * @param $data
     * @return string
     */
    public function array2string($data): string
    {
        $log_a = "";
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $log_a .= "$key=$value";
                if ($key !== array_key_last($data)) {
                    $log_a .= '&';
                }
            }
        }
        return $log_a;
    }

    /**
     * @param $names
     * @param  Request  $request
     * @return array
     */
    public function generateLinkForSorting($names, Request $request): array
    {
        $links = array();
        $order = $request->get('order');
        if ($order === 'desc') {
            $order_new = 'asc';
        } else {
            $order_new = 'desc';
        }
        foreach ($names as $name) {
            $links[$name] = $request->fullUrlWithQuery(['sort_by' => $name, 'order' => $order_new]);
        }
        return $links;
    }

    /**
     * @param  Request  $request
     * @return false
     */
    public function checkCustomDiscount(Request $request): bool
    {
        return $request->session()->has('pt') ||
            $request->session()->has('pd') ||
            $request->session()->has('rh') ||
            $request->session()->has('d_pt') ||
            $request->session()->has('d_pd') ||
            $request->session()->has('d_rh');
    }

    /**
     * @param $purchasesInfo
     * @param $model
     */
    public static function countPurchases($purchasesInfo, $model): void
    {
        $catalyst       = 0;
        $pdPurchase     = 0;
        $ptPurchase     = 0;
        $rhPurchase     = 0;
        $weightPurchase = 0;
        if ($purchasesInfo) {
            foreach ($purchasesInfo as $item) {
                foreach ($item->catalogs as $catalog) {
                    $catalyst       += $catalog->pivot->count;
                    $pdPurchase     += $item->pd * $catalog->pivot->count;
                    $ptPurchase     += $item->pt * $catalog->pivot->count;
                    $rhPurchase     += $item->rh * $catalog->pivot->count;
                    $weightPurchase = $item->weight * $catalog->pivot->count;
                }
            }
        }
        $model->pt_purchase     = $ptPurchase;
        $model->pd_purchase     = $pdPurchase;
        $model->rh_purchase     = $rhPurchase;
        $model->weight_ceramics = $weightPurchase;
        $model->catalyst        = $catalyst;
    }

}
