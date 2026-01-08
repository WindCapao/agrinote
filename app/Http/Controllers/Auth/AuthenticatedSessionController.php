<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    
    public function create(): View
    {
        return view('auth.login'); //show login form
    }

    public function store(LoginRequest $request): RedirectResponse  //process login
    {
        $request->authenticate(); //attempt login. check email + password

        $request->session()->regenerate();  //create new session to prevent fixation 

        return redirect()->intended('/'); //redirect to intended page or home
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout(); //log out user

        $request->session()->invalidate(); //delete session

        $request->session()->regenerateToken();

        return redirect('/');  //redirect to home
    }
}
