<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureValidPath
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    public function handle(Request $request, Closure $next): Response
    {
        $requestedUserId = $request->route('apartment');


        if ($requestedUserId != null && $requestedUserId['user_id'] != Auth::id()) {
            abort(403, 'Unauthorized');
        }


        return $next($request);
    }
}
