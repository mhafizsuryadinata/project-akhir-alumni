<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah alumni
        $jumlahAlumni = User::where('role', 'alumni')->count();
        
        // ID user sistem untuk komentar aplikasi
        $systemUserId = 0; // Sesuaikan dengan ID yang Anda buat
        
        // Ambil 4 komentar terbaik (rating 4-5 bintang, terbaru)
        $testimonials = Comment::where('target_user_id', 0)
            ->whereNull('parent_id') // Hanya komentar utama, bukan balasan
            ->where('rating', '>=', 3) // Rating minimal 3
            ->where('admin_status', 'approved')
            ->where('mudir_status', 'approved')
            ->with('user') // Load relasi user
            ->latest() // Urutkan terbaru
            ->take(4) // Ambil 4 komentar
            ->get();
        
        return view('dashboard', compact('jumlahAlumni', 'testimonials'));
    }
    
    public function jhAlumni()
    {
        $jumlahAlumni = User::where('role', 'alumni')->count();
        
        $systemUserId = 1;
        
        $testimonials = Comment::where('target_user_id', $systemUserId)
            ->whereNull('parent_id')
            ->where('rating', '>=', 4)
            ->with('user')
            ->latest()
            ->take(4)
            ->get();
        
        return view('dashboard', compact('jumlahAlumni', 'testimonials'));
    }
}