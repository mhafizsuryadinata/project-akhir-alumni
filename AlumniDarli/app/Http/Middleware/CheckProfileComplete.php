<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckProfileComplete
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'alumni' && !Auth::user()->is_complete) {
            return redirect('akun')->with('warning', 'Lengkapi biodata dulu sebelum lanjut.');
        }

        return $next($request);
    }
}
