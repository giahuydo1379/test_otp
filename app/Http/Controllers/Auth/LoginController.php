<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyMail;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    public function authenticated()
    {

        $user = Auth::user();
       // $user->token_2fa_expiry = \Carbon\Carbon::now();
        $user->token_2fa_expiry = \Carbon\Carbon::now()->addMinutes(config('session.lifetime'));
        $user->token_2fa = mt_rand(10000,99999);
        $user->save();

        Mail::to($user->email)->send(new VerifyMail($user));

        return redirect('/2fa');

    }

    protected function redirectTo()
    {
        return '/';
    }
}
