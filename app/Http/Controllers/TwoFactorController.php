<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class TwoFactorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('two_factor');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            '2fa' => 'required',
        ]);

        if ($request->input('2fa') == Auth::user()->token_2fa) {
            $user = Auth::user();
            $user->token_2fa_expiry = \Carbon\Carbon::now()->addMinutes(config('session.lifetime'));
            $user->save();
            return redirect('/home');
        } else {
            return redirect('/2fa')->with('message', 'Incorrect code.');
        }
    }

    public function showTwoFactorForm()
    {
        return view('two_factor');
    }
    public function showAdmin()
    {
        return view('home');
    }
}
