<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); 
    }

    /**
     * Open login page.
     *
     * @return view
     */
    public function showLoginForm()
    {
        return view('auth.login', [
            'items_amount' => Auth::user() ? count(Auth::user()->cart_items) : 0
        ]);
    }

    /**
     * Exit account.
     *
     * @redirect back
     */
    public function logout() {
        if(Auth::check()){
            Auth::logout();
        }
        
        return redirect()->back();
    }

    /**
     * Redirect link after successful login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $parsed = parse_url(url()->previous());
        return $parsed['path'];
    }
}
