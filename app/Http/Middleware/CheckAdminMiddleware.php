<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $role = auth()->user()->role_type();

        if ($role != 'admin') {
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }

        return $next($request);
    }
}
