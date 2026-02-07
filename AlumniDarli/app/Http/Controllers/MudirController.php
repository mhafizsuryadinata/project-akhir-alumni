<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Album;
use App\Models\Galeri;
use App\Models\Lowongan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MudirController extends Controller
{
    public function index()
    {
        $today = \Carbon\Carbon::today();
        $lastWeek = \Carbon\Carbon::today()->subDays(6);

        // Core Stats
        $stats = [
            'total_alumni' => \App\Models\User::where('role', 'alumni')->count(),
            'total_event' => \App\Models\Event::count(),
            'total_lowongan' => \App\Models\Lowongan::count(),
            'total_komentar' => \App\Models\Comment::count(),
            'total_album' => \App\Models\Album::count(),
        ];

        // Helper for trends (compared to last week)
        $getTrend = function($query, $days = 7) {
            $current = (clone $query)->where('created_at', '>=', \Carbon\Carbon::today()->subDays($days))->count();
            $previous = (clone $query)->whereBetween('created_at', [
                \Carbon\Carbon::today()->subDays($days * 2),
                \Carbon\Carbon::today()->subDays($days)
            ])->count();
            
            if ($previous == 0) return $current > 0 ? 100 : 0;
            return round((($current - $previous) / $previous) * 100, 1);
        };

        $trends = [
            'alumni' => $getTrend(\App\Models\User::where('role', 'alumni')),
            'event' => $getTrend(\App\Models\Event::query()),
            'lowongan' => $getTrend(\App\Models\Lowongan::query()),
            'komentar' => $getTrend(\App\Models\Comment::query()),
        ];

        // 7-Day Activity Data for Chart
        $chartData = [];
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::today()->subDays($i);
            $labels[] = $date->format('d M');
            
            $chartData['alumni'][] = \App\Models\User::where('role', 'alumni')->whereDate('created_at', $date)->count();
            $chartData['komentar'][] = \App\Models\Comment::whereDate('created_at', $date)->count();
            $chartData['event'][] = \App\Models\Event::whereDate('created_at', $date)->count();
            $chartData['lowongan'][] = \App\Models\Lowongan::whereDate('created_at', $date)->count();
        }

        return view('mudir.dashboard', compact('stats', 'trends', 'chartData', 'labels'));
    }

    public function tampilKomentar()
    {
        // Pimpinan memeriksa komentar yang sudah disetujui Admin tapi belum disetujui Pimpinan
        // Atau semua komentar untuk pengawasan ganda
        $comments = \App\Models\Comment::with(['user', 'target', 'replies'])
            ->whereNull('parent_id')
            ->latest()
            ->get();

        $stats = [
            'total' => \App\Models\Comment::count(),
            'approved' => \App\Models\Comment::where('mudir_status', 'approved')->count(),
            'pending' => \App\Models\Comment::where('mudir_status', 'pending')->count(),
            'rejected' => \App\Models\Comment::where('mudir_status', 'rejected')->count(),
        ];

        return view('mudir.komentar', compact('comments', 'stats'));
    }

    public function approveKomentar($id)
    {
        try {
            $comment = \App\Models\Comment::findOrFail($id);
            $comment->mudir_status = 'approved';
            $comment->save();
            
            return back()->with('success', 'Komentar berhasil disetujui oleh Pimpinan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyetujui komentar: ' . $e->getMessage());
        }
    }

    public function rejectKomentar($id)
    {
        try {
            $comment = \App\Models\Comment::findOrFail($id);
            $comment->mudir_status = 'rejected';
            $comment->save();
            
            return back()->with('success', 'Komentar berhasil ditolak oleh Pimpinan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menolak komentar: ' . $e->getMessage());
        }
    }

    public function balasKomentar(Request $request, $id)
    {
        $request->validate([
            'balasan' => 'required|string|max:1000'
        ]);

        try {
            $comment = \App\Models\Comment::findOrFail($id);
            $comment->mudir_reply = $request->balasan;
            $comment->mudir_reply_date = now();
            $comment->save();

            return back()->with('success', 'Balasan Pimpinan berhasil dikirim!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim balasan: ' . $e->getMessage());
        }
    }

    public function akun()
    {
        $user = auth()->user();
        
        // Statistik Sistem untuk Mudir
        $totalAlumni = \App\Models\User::where('role', 'alumni')->count();
        $totalEvents = \App\Models\Event::count();
        
        return view('mudir.akun', compact('user', 'totalAlumni', 'totalEvents'));
    }

    public function updateAkun(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'bio' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;
        $user->bio = $request->bio;

        if ($request->hasFile('foto')) {
            if ($user->foto && \Storage::exists('public/' . $user->foto)) {
                \Storage::delete('public/' . $user->foto);
            }
            $path = $request->file('foto')->store('uploads/mudir', 'public');
            $user->foto = $path;
            $user->profile = $path;
        }

        $user->save();

        return back()->with('success', 'Profil Pimpinan berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.']);
        }

        $user->password = \Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Kata sandi Pimpinan berhasil diperbarui!');
    }

    public function eventIndex()
    {
        $events = \App\Models\Event::with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $stats = [
            'total' => \App\Models\Event::count(),
            'upcoming' => \App\Models\Event::where('date', '>=', now()->toDateString())->count(),
            'past' => \App\Models\Event::where('date', '<', now()->toDateString())->count(),
            'approved' => \App\Models\Event::where('status_pimpinan', 'approved')->count(),
            'rejected' => \App\Models\Event::where('status_pimpinan', 'rejected')->count(),
        ];
        
        return view('mudir.event', compact('events', 'stats'));
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $data['image'] = $imagePath;
        }

        $data['user_id'] = auth()->user()->id_user;
        $data['status_admin'] = 'approved';
        $data['status_pimpinan'] = 'approved';

        try {
            \App\Models\Event::create($data);
            return back()->with('success', 'Event berhasil dibuat oleh Pimpinan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat event: ' . $e->getMessage());
        }
    }

    public function editEvent($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        return response()->json($event);
    }

    public function updateEvent(Request $request, $id)
    {
        $event = \App\Models\Event::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($event->image) {
                \Storage::disk('public')->delete($event->image);
            }
            $imagePath = $request->file('image')->store('events', 'public');
            $data['image'] = $imagePath;
        }

        try {
            $event->update($data);
            return back()->with('success', 'Event berhasil diperbarui oleh Pimpinan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui event: ' . $e->getMessage());
        }
    }

    public function destroyEvent($id)
    {
        try {
            $event = \App\Models\Event::findOrFail($id);
            if ($event->image) {
                \Storage::disk('public')->delete($event->image);
            }
            $event->delete();
            return back()->with('success', 'Event berhasil dihapus oleh Pimpinan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus event: ' . $e->getMessage());
        }
    }

    public function approveEvent($id)
    {
        try {
            $event = \App\Models\Event::findOrFail($id);
            $event->status_pimpinan = 'approved';
            $event->save();

            return back()->with('success', 'Event berhasil disetujui oleh Pimpinan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyetujui event: ' . $e->getMessage());
        }
    }

    public function rejectEvent($id)
    {
        try {
            $event = \App\Models\Event::findOrFail($id);
            $event->status_pimpinan = 'rejected';
            $event->save();

            return back()->with('success', 'Event berhasil ditolak oleh Pimpinan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menolak event: ' . $e->getMessage());
        }
    }

    public function showEvent($id)
    {
        $event = \App\Models\Event::with('user', 'participants')->findOrFail($id);
        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'category' => $event->category,
            'date' => $event->date,
            'time' => $event->time,
            'location' => $event->location,
            'description' => $event->description,
            'image' => $event->image ? asset('storage/' . $event->image) : null,
            'creator' => $event->user ? $event->user->nama : 'Unknown',
            'participants_count' => $event->participants->count(),
            'status_admin' => $event->status_admin,
            'status_pimpinan' => $event->status_pimpinan,
            'created_at' => $event->created_at->format('d M Y H:i'),
        ]);
    }

    // ========================================================
    // MANAJEMEN GALERI
    // ========================================================

    public function galeriIndex()
    {
        $stats = [
            'total_album' => Album::count(),
            'total_photo' => Galeri::whereIn('tipe', ['photo', 'foto'])->count(),
            'total_video' => Galeri::where('tipe', 'video')->count(),
        ];

        $albums = Album::with(['galeri', 'creator'])->withCount(['galeri as total_photos' => function ($query) {
            $query->whereIn('tipe', ['photo', 'foto']);
        }, 'galeri as total_videos' => function ($query) {
            $query->where('tipe', 'video');
        }])->latest()->get();

        return view('mudir.galeri.index', compact('stats', 'albums'));
    }

    public function showAlbum($id)
    {
        $album = Album::with(['galeri.uploader', 'creator'])->findOrFail($id);
        
        $stats = [
            'photos' => $album->galeri->whereIn('tipe', ['photo', 'foto'])->count(),
            'videos' => $album->galeri->where('tipe', 'video')->count(),
        ];

        return view('mudir.galeri.show', compact('album', 'stats'));
    }

    public function storeAlbum(Request $request)
    {
        $request->validate([
            'nama_album' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'kategori' => 'required|string',
            'deskripsi' => 'nullable|string',
            'cover' => 'nullable|image|max:2048'
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        Album::create([
            'nama_album' => $request->nama_album,
            'tahun' => $request->tahun,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'cover' => $coverPath,
            'created_by' => Auth::user()->id_user,
            'status_admin' => 'approved',
            'status_pimpinan' => 'approved'
        ]);

        return redirect()->back()->with('success', 'Album berhasil dibuat!');
    }

    public function updateAlbum(Request $request, $id)
    {
        $album = Album::findOrFail($id);

        $request->validate([
            'nama_album' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'kategori' => 'required|string',
            'deskripsi' => 'nullable|string',
            'cover' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('cover')) {
            if ($album->cover && Storage::disk('public')->exists($album->cover)) {
                Storage::disk('public')->delete($album->cover);
            }
            $album->cover = $request->file('cover')->store('covers', 'public');
        }

        $album->update([
            'nama_album' => $request->nama_album,
            'tahun' => $request->tahun,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Album berhasil diperbarui!');
    }

    public function destroyAlbum($id)
    {
        $album = Album::with('galeri')->findOrFail($id);

        foreach ($album->galeri as $media) {
            if (Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
        }

        if ($album->cover && Storage::disk('public')->exists($album->cover)) {
            Storage::disk('public')->delete($album->cover);
        }

        $album->galeri()->delete();
        $album->delete();

        return redirect()->back()->with('success', 'Album berhasil dihapus!');
    }

    public function approveAlbum($id)
    {
        $album = Album::findOrFail($id);
        $album->status_pimpinan = 'approved';
        $album->save();
        return redirect()->back()->with('success', 'Album disetujui!');
    }

    public function rejectAlbum($id)
    {
        $album = Album::findOrFail($id);
        $album->status_pimpinan = 'rejected';
        $album->save();
        return redirect()->back()->with('success', 'Album ditolak!');
    }

    public function uploadMedia(Request $request, $id)
    {
        $album = Album::findOrFail($id);

        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:20480',
            'deskripsi' => 'nullable|string'
        ]);

        $file = $request->file('file');
        $tipe = str_starts_with($file->getMimeType(), 'image') ? 'foto' : 'video';
        
        $path = $file->store('galeri/' . $album->id, 'public');

        Galeri::create([
            'album_id' => $album->id,
            'file_path' => $path,
            'tipe' => $tipe,
            'deskripsi' => $request->deskripsi,
            'uploaded_by' => Auth::user()->id_user,
            'status_admin' => 'approved',
            'status_pimpinan' => 'approved'
        ]);

        return redirect()->back()->with('success', 'Media berhasil diupload!');
    }

    public function destroyMedia($id)
    {
        $media = Galeri::findOrFail($id);

        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        return redirect()->back()->with('success', 'Media berhasil dihapus!');
    }

    public function approveMedia($id)
    {
        $media = Galeri::findOrFail($id);
        $media->status_pimpinan = 'approved';
        $media->save();
        return redirect()->back()->with('success', 'Media disetujui!');
    }

    public function rejectMedia($id)
    {
        $media = Galeri::findOrFail($id);
        $media->status_pimpinan = 'rejected';
        $media->save();
        return redirect()->back()->with('success', 'Media ditolak!');
    }

    // ========================================================
    // MANAJEMEN LOWONGAN
    // ========================================================

    public function lowonganIndex()
    {
        $stats = [
            'total' => Lowongan::count(),
            'aktif' => Lowongan::where('status', 'Aktif')->where('tanggal_tutup', '>=', now())->count(),
            'tutup' => Lowongan::where('status', 'Ditutup')->orWhere('tanggal_tutup', '<', now())->count(),
        ];

        $lowongan = Lowongan::with('poster')->withCount('lamaran')->latest()->get();
        return view('mudir.lowongan.index', compact('lowongan', 'stats'));
    }

    public function storeLowongan(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tipe_pekerjaan' => 'required|in:Full Time,Part Time,Freelance,Contract,Internship',
            'level' => 'required|in:Entry Level,Mid Level,Senior Level,Manager,Director',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'benefit' => 'nullable|string',
            'gaji_min' => 'nullable|string|max:50',
            'gaji_max' => 'nullable|string|max:50',
            'email_kontak' => 'required|email',
            'website' => 'nullable|url',
            'tanggal_tutup' => 'required|date|after:today',
            'logo_perusahaan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('logo_perusahaan');
        
        if ($request->hasFile('logo_perusahaan')) {
            $path = $request->file('logo_perusahaan')->store('lowongan/logos', 'public');
            $data['logo_perusahaan'] = 'storage/' . $path;
        }
        
        $data['posted_by'] = Auth::user()->id_user;
        $data['status'] = 'Aktif';
        $data['status_admin'] = 'approved';
        $data['status_pimpinan'] = 'approved';
        
        Lowongan::create($data);
        
        return redirect()->back()->with('success', 'Lowongan berhasil ditambahkan!');
    }

    public function updateLowongan(Request $request, $id)
    {
        $lowongan = Lowongan::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tipe_pekerjaan' => 'required|in:Full Time,Part Time,Freelance,Contract,Internship',
            'level' => 'required|in:Entry Level,Mid Level,Senior Level,Manager,Director',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'benefit' => 'nullable|string',
            'gaji_min' => 'nullable|string|max:50',
            'gaji_max' => 'nullable|string|max:50',
            'email_kontak' => 'required|email',
            'website' => 'nullable|url',
            'tanggal_tutup' => 'required|date',
            'status' => 'required|in:Aktif,Ditutup,Draft',
            'logo_perusahaan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('logo_perusahaan');
        
        if ($request->hasFile('logo_perusahaan')) {
            if ($lowongan->logo_perusahaan) {
                Storage::disk('public')->delete(str_replace('storage/', '', $lowongan->logo_perusahaan));
            }
            $path = $request->file('logo_perusahaan')->store('lowongan/logos', 'public');
            $data['logo_perusahaan'] = 'storage/' . $path;
        }
        
        $lowongan->update($data);
        
        return redirect()->back()->with('success', 'Lowongan berhasil diperbarui!');
    }

    public function destroyLowongan($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        
        if ($lowongan->logo_perusahaan) {
            Storage::disk('public')->delete(str_replace('storage/', '', $lowongan->logo_perusahaan));
        }
        
        $lowongan->delete();
        
        return redirect()->back()->with('success', 'Lowongan berhasil dihapus!');
    }

    public function approveLowongan($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->status_pimpinan = 'approved';
        $lowongan->save();
        return redirect()->back()->with('success', 'Lowongan disetujui!');
    }

    public function rejectLowongan($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->status_pimpinan = 'rejected';
        $lowongan->save();
        return redirect()->back()->with('success', 'Lowongan ditolak!');
    }

    public function showLowongan($id)
    {
        $lowongan = Lowongan::with(['lamaran.user', 'poster'])->findOrFail($id);
        
        $stats = [
            'total_pelamar' => $lowongan->lamaran->count(),
            'hari_sisa' => now()->diffInDays($lowongan->tanggal_tutup, false)
        ];

        return view('mudir.lowongan.show', compact('lowongan', 'stats'));
    }

    public function downloadCv($id)
    {
        $lamaran = \App\Models\Lamaran::findOrFail($id);
        
        if (Storage::disk('public')->exists($lamaran->cv_path)) {
            return Storage::disk('public')->download($lamaran->cv_path);
        }
        
        return back()->with('error', 'File CV tidak ditemukan.');
    }

    public function updateStatusLamaran(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diterima,Ditolak'
        ]);

        $lamaran = \App\Models\Lamaran::findOrFail($id);
        $lamaran->update([
            'status_pimpinan' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status lamaran berhasil diperbarui oleh Pimpinan!');
    }

    // ========================================================
    // MANAJEMEN ALUMNI
    // ========================================================

    public function tampilAlumni()
    {
        $users = \App\Models\User::where('role', 'alumni')->get();
        return view('mudir.alumni.tampilAlumni', compact('users'));
    }

    public function simpanAlumni(Request $request)
    {
        $request->validate([
            'nomor_nia' => 'required|string|unique:users,nomor_nia',
            'username' => 'required|string|unique:users,username',
            'tahun_masuk' => 'nullable|integer',
            'tahun_tamat' => 'nullable|integer',
        ]);

        \App\Models\User::create([
            'nomor_nia' => $request->nomor_nia,
            'username' => $request->username,
            'tahun_masuk' => $request->tahun_masuk,
            'tahun_tamat' => $request->tahun_tamat,
            'role' => 'alumni'
        ]);

        return redirect()->route('mudir.alumni.index')->with('pesan', 'Data Alumni Berhasil Tersimpan!');
    }

    public function editAlumni($id_user)
    {
        $users = \App\Models\User::where('id_user', $id_user)->first();
        return view('mudir.alumni.editAlumni', compact('users'));
    }

    public function updateAlumni(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'nomor_nia' => 'required|string',
            'username' => 'required|string',
        ]);

        \App\Models\User::where('id_user', $request->id_user)
            ->update([
                'nomor_nia' => $request->nomor_nia,
                'username' => $request->username,
                'nama' => $request->nama,
                'pekerjaan' => $request->pekerjaan,
                'email' => $request->email,
                'lokasi' => $request->lokasi,
                'tahun_masuk' => $request->tahun_masuk,
                'tahun_tamat' => $request->tahun_tamat,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

        return redirect()->route('mudir.alumni.index')->with('pesan', 'Data Alumni Berhasil Diperbarui!');
    }

    public function hapusAlumni($id_user)
    {
        \App\Models\User::where('id_user', $id_user)->delete();
        return redirect()->route('mudir.alumni.index')->with('pesan', 'Data Alumni Berhasil Dihapus!');
    }
}
