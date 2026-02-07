<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;
use App\Models\Event;
use App\Models\KontakUstadz;
use Auth;

class AlumniController extends Controller
{
    public function alumni()
    {
        $users = User::where('role', 'alumni')
            ->where('id_user', '!=', Auth::user()->id_user)
            ->get();
        
        $jumlahAlumni2 = User::where('role', 'alumni')->count();
        
        // Load komentar untuk aplikasi (bukan user tertentu)
        // Gunakan ID khusus untuk aplikasi, misal 0 atau buat konstanta
        $comments = Comment::where('target_user_id', 0) // 0 = komentar untuk aplikasi
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('admin_status', 'approved')
                      ->where('mudir_status', 'approved');
                })->orWhere('user_id', Auth::user()->id_user);
            })
            ->latest()
            ->get();

        // Fetch latest events
        $upcoming_events = Event::latest()
            ->take(3)
            ->get();



        $total_upcoming = Event::where('date', '>', now()->toDateString())
            ->orWhere(function($q) {
                $q->where('date', '=', now()->toDateString())
                  ->where('time', '>', now()->toTimeString());
            })->count();
        
        // Fetch Info Pondok
        $info_pondok = \App\Models\InfoPondok::latest()->take(5)->get();
        
        // Fetch Kontak Ustadz
        $kontak_ustadz = KontakUstadz::all();

        // Fetch Stats
        $total_events_year = Event::whereYear('date', date('Y'))->count();
        $total_ustadz = $kontak_ustadz->count();
        $total_lowongan = \App\Models\Lowongan::count();

        // Fetch Admin and Mudir data for comments
        $admin = User::where('role', 'admin')->first();
        $mudir = User::where('role', 'pimpinan')->first();

        return view('alumni.dashboardAlumni', compact(
            'users', 
            'jumlahAlumni2', 
            'comments', 
            'upcoming_events', 
            'total_upcoming', 
            'info_pondok', 
            'kontak_ustadz',
            'total_events_year',
            'total_ustadz',
            'total_lowongan',
            'admin',
            'mudir'
        ));
    }

    public function lowongan()
    {
        return view ('alumni.lowongan');
    }   

    public function kontak()
    {
        $ustadz = \App\Models\KontakUstadz::all();
        $faqs = \App\Models\Faq::orderBy('order')->get();
        $my_messages = \App\Models\ContactMessage::where('user_id', Auth::user()->id_user)
            ->latest()
            ->get();
        return view ('alumni.kontak', compact('ustadz', 'faqs', 'my_messages'));
    }

}
