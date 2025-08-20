<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek jika user tidak login (session expired)
        if (!$request->user()) {
            return redirect()->route('login')->with('message', 'Tidak ada aktivitas selama 1800 detik atau lebih. Harap masuk kembali.');
        }
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
} 