<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Redirect berdasarkan role user
                if ($user->role === 'admin') {
                    return redirect()->route('admin')->with('info', 'Anda sudah login sebagai Admin');
                } elseif ($user->role === 'alumni') {
                    if ($user->is_complete) {
                        return redirect()->route('alumni')->with('info', 'Anda sudah login');
                    } else {
                        return redirect()->route('akun')->with('info', 'Lengkapi profil Anda terlebih dahulu');
                    }
                }
                
                // Default redirect jika role tidak dikenali
                return redirect()->route('akun');
            }
        }

        return $next($request);
    }
}
