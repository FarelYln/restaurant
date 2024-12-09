<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check()) {
            if (auth()->user()->role === $role) {
                return $next($request);
            } else {
                // Jika pengguna tidak memiliki peran yang sesuai, arahkan ke halaman landing
                return redirect('/');
            }
        }

        // Jika pengguna tidak terautentikasi, arahkan ke halaman login atau landing
        return redirect('/'); // Atau bisa juga ke route login
    }
}