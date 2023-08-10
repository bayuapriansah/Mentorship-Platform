<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class SecurityHeadersMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $userAgent = $request->header('User-Agent');

        // Check if user agent is set and contains a valid value
        if (!$userAgent || preg_match('/^(?!Mozilla.*(Gecko|WebKit)).*/', $userAgent)) {
            return response('Invalid User-Agent', 400);
        }

        $response = $next($request);

        if ($response instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse) {
            $response->headers->set('Content-Security-Policy', "frame-ancestors 'self'");
            $response->headers->set('X-Frame-Options', 'DENY');
        } else {
            $response->header('Content-Security-Policy', "frame-ancestors 'self'");
            $response->header('X-Frame-Options', 'DENY');
        }

        return $response;
    }
}

