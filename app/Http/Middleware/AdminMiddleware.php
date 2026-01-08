<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response //check admin access
    {
        if (!Auth::check()) {                   //  not logged in
            return redirect()->route('login');  //  redirect to login if not logged in
        }

        if (!Auth::user()->isAdmin()) { //  not admin
            abort(403, 'This action requires admin privileges.');  // 403 if not admin
        }

        return $next($request);
    }
}