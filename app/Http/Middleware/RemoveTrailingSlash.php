<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RemoveTrailingSlash
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
        $uri = $request->getRequestUri();

        // Remove trailing slash if present
        if ($uri !== '/' && substr($uri, -1) === '/') {
            return redirect(rtrim($uri, '/'), 301);
        }

        return $next($request);
    }
}
