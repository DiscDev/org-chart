<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ResponseCaching
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->isMethod('GET')) {
            return $next($request);
        }

        $key = 'response_' . sha1($request->fullUrl() . '|' . auth()->id());

        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $response = $next($request);

        if ($response->status() === 200) {
            Cache::put($key, $response, now()->addMinutes(5));
        }

        return $response;
    }
}