<?php


namespace App\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Class MainController
 * @package App\Http\Controllers
 */
class MainController extends Controller
{
    /**
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function login(Request $request)
    {
        return view('auth', [
            'error' => Session::has('error')
        ]);
    }

    /**
     * @param  Request  $request
     * @return Application|RedirectResponse|Redirector
     */
    public function auth(Request $request)
    {
        $validator = Validator::make(
            $request->post(),
            [
                'login'    => 'required|email',
                'password' => 'required',
            ],
            [
                'login.required'    => __('auth.error.login.required'),
                'password.required' => __('auth.error.password.required'),
            ]
        );
        if (!$validator->fails() && Auth::attempt(
                [
                    'email'    => $request->post('login'),
                    'password' => $request->post('password')
                ],
                true
            )) {
            return redirect()->route('main');
        }

        return redirect()->back()->with('error', true);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return redirect()->route('dashboard');
    }
}