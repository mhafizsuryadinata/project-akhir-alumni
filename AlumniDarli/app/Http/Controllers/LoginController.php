<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login()
    {
        // Jika sudah login, redirect ke halaman sesuai role
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                return redirect()->route('admin')->with('info', 'Anda sudah login sebagai Admin');
            } elseif ($user->role === 'alumni') {
                if ($user->is_complete) {
                    return redirect()->route('alumni')->with('info', 'Anda sudah login');
                } else {
                    return redirect()->route('akun')->with('info', 'Lengkapi profil Anda terlebih dahulu');
                }
            } elseif ($user->role === 'pimpinan') {
                return redirect()->route('mudir.dashboard')->with('info', 'Anda sudah login sebagai Pimpinan');
            }
            
            return redirect()->route('akun');
        }
        
        $admin = User::where('role', 'admin')->first();
        return view('login', compact('admin'));
    }

    public function actionLogin(Request $request)
    {
        // ambil user dari DB
        $user = User::where('nomor_nia', $request->nomor_nia)
                    ->where('username', $request->username)
                    ->first();

        if ($user) {
            Auth::login($user);

            if ($user->role === 'alumni') {
                if (!$user->is_complete) {
                    // kalau biodata belum lengkap
                    return redirect('akun')->with('info', 'Lengkapi biodata dulu, ' . $user->username);
                } else {
                    // kalau sudah lengkap
                    return redirect('alumni')->with('success', 'Selamat datang Alumni, ' . $user->username);
                }
            } elseif ($user->role === 'admin') {
                return redirect('admin')->with('success', 'Selamat datang Admin, ' . $user->username);
            } elseif ($user->role === 'pimpinan') {
                return redirect()->route('mudir.dashboard')->with('success', 'Selamat datang Pimpinan, ' . $user->username);
            } else {
                return redirect('/')->with('warning', 'Role tidak dikenali, masuk ke halaman default.');
            }
        } else {
            return redirect()->route('hubungiAdmin');
        }
    }

    public function hubungiAdmin()
    {
        return view('hubungiAdmin');
    }

    function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logout Berhasil!');
    }
}
