<?php

namespace App\Rules;

use App\Models\Catalog;
use App\Models\Discount;
use App\Models\Lots;
use App\Models\Purchase;
use App\Models\PurchaseStatus;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CheckStatusAndUserBeforeTransfer implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public object $request;
    public ?int    $id;

    public function __construct($request, $id)
    {
        $this->request = $request;
        $this->id      = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Получаем тотал
        $total    = 0;
        $lots     = Lots::find($this->request->post('lot'));
        $discount = Discount::where('space_id', Auth::user()->space_id)->first();
        $discount = $discount ?? new Discount();
        $cat      = is_array($this->request->post('cat')) ? $this->request->post('cat') : [];
        $categoriesData                  = is_array($this->request->post('categories')) ? $this->request->post('categories') : [];

        $calc     = Catalog::calcCategoriesMetal($categoriesData, $lots, $discount, $cat);
        $total    = Purchase::countTotal($calc['price'], ((int) $discount->purchase_discount / 100));
        // Получили тотал
        $statusInfo = PurchaseStatus::find($this->request->post('status_id'));
        if ($this->id) {
            $purchaseInfo = Purchase::find($this->id);
        } else {
            $purchaseInfo          = new Purchase();
            $purchaseInfo->user_id = Auth::id();
        }
        if ($purchaseInfo->status && $purchaseInfo->status->final) {
            return true;
        }
        if (!$statusInfo) {
            return false;
        }
        if (!$purchaseInfo) {
            return false;
        }
        $userInfo = User::find($purchaseInfo->user_id);
        return !($statusInfo->final && $userInfo->balance < $total);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('purchase.errors.status_id_transfer');
    }
}
