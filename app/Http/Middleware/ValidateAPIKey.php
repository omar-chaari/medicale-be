<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Patient;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class ValidateAPIKey
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
        $authorizationHeader = $request->header('Authorization');
        $apiKey = str_replace('Bearer ', '', $authorizationHeader);
        

        
        if (!$apiKey || (!Admin::where('api_key', $apiKey)->exists()
        && !Patient::where('api_key', $apiKey)->exists()
        && !User::where('api_key', $apiKey)->exists()
        
        )
        ) {
            return response()->json(['error' => 'Invalid API Key'], 401);
        }
        return $next($request);
    }
}
