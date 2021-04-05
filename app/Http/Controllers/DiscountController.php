<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $discount = Discount::where('space_id', Auth::user()->space_id)->first();
        $discount = $discount ?? new Discount();
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'pt_discount'       => 'required|numeric',
                'pd_discount'       => 'required|numeric',
                'rh_discount'       => 'required|numeric',
                'purchase_discount' => 'required|numeric'
            ]);

            $discount->pt_discount       = $request->post('pt_discount');
            $discount->pd_discount       = $request->post('pd_discount');
            $discount->rh_discount       = $request->post('rh_discount');
            $discount->purchase_discount = $request->post('purchase_discount');
            if (empty($discount->id)) {
                $discount->space_id = Auth::user()->space_id;
            }
            $discount->save();
            return redirect(route('discount.form'))->with('success', __('index.success'));
        }
        return view('panel.discount.form', [
            'discount'   => $discount,
            'success'    => Session::get('success'),
            'breadcrumb' => [
                'title' => __('sidebar.manageDiscount'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ], [
                            'link'   => route('discount.form'),
                            'name'   => __('sidebar.manageDiscount'),
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }
}
