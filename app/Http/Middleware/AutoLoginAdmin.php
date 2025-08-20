<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AutoLoginAdmin
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
        // Cek jika route saat ini adalah login atau register, jangan auto login
        $excludedRoutes = ['login', 'register'];
        if (
            app()->environment('local') &&
            !auth()->check() &&
            !in_array($request->route()->getName(), $excludedRoutes)
        ) {
            $admin = User::where('role', 'supervisor')->first();
            if ($admin) {
                auth()->login($admin);
            }
        }
        return $next($request);
    }
} 