<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedAndLocked
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && \Session::get('lockout') === true) {
            return redirect()->route('lockout_path')->withError('This session is locked.');
        }

        return $next($request);
    }
}
