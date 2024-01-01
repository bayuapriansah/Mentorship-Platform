<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSessionExpiry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $expiryTime = $request->session()->get('expiry_time');

        if ($expiryTime && now()->greaterThan($expiryTime)) {
            Auth::logout();
            $request->session()->invalidate();
            return redirect('/login')->with('message', 'Your session has expired.');
        }

        return $next($request);
    }
}
