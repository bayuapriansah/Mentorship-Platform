<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeadersMiddleware
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
        // return $next($request);
        $userAgent = $request->header('User-Agent');

        // Check if user agent is set and contains a valid value
        if (!$userAgent || preg_match('/^(?!Mozilla.*(Gecko|WebKit)).*/', $userAgent)) {
            return response('Invalid User-Agent', 400);
        }

        $response = $next($request);

        $response->header('Content-Security-Policy', "frame-ancestors 'self'");
        $response->header('X-Frame-Options', 'DENY');

        return $response;
    }
}
