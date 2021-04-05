<?php


namespace App\Http\Controllers;


class DashboardController extends Controller
{
    public function index()
    {
        return view('panel.dashboard', [
            'breadcrumb' => [
                'title' => __('dashboard.title'),
                'bc'    =>
                    [
                        [
                            'link'   => route('main'),
                            'name'   => __('dashboard.main'),
                            'active' => false
                        ],  [
                            'link'   => route('dashboard'),
                            'name'   => __('dashboard.title'),
                            'active' => true
                        ],
                    ]
            ]
        ]);
    }
}