<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ImageAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Perform your authorization logic here
        
    
        
        $allowedIPs = [env('FRONTEND_IP') ]; 

        if (!in_array($request->ip(), $allowedIPs)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }

}