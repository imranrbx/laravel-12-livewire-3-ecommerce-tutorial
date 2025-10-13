<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }
    

        // Optional: redirect non-admins to homepage or 403 page
        return redirect()->route('home')->with('error', 'Unauthorized Access!');
    }
}
