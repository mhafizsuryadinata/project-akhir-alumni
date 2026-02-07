<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;
use App\Models\KontakUstadz;
use Session;

class AdminController extends Controller
{
    public function admin() {
        // Core Stats
        $stats = [
            'total_alumni' => \App\Models\User::where('role', 'alumni')->count(),
            'total_event' => \App\Models\Event::count(),
            'total_info' => \App\Models\InfoPondok::count(),
            'total_komentar' => \App\Models\Comment::count(),
            'total_galeri' => \App\Models\Album::count(),
            'total_lowongan' => \App\Models\Lowongan::count(),
            'total_pesan' => \App\Models\ContactMessage::count(),
            'total_faq' => \App\Models\Faq::count(),
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
            'komentar' => $getTrend(\App\Models\Comment::query()),
            'pesan' => $getTrend(\App\Models\ContactMessage::query()),
        ];

        // 7-Day Activity Data for Chart
        $chartData = [];
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::today()->subDays($i);
            $labels[] = $date->format('d M');
            $chartData['alumni'][] = \App\Models\User::where('role', 'alumni')->whereDate('created_at', $date)->count();
            $chartData['komentar'][] = \App\Models\Comment::whereDate('created_at', $date)->count();
            $chartData['pesan'][] = \App\Models\ContactMessage::whereDate('created_at', $date)->count();
        }

        return view('admin.homeAdmin', compact('stats', 'trends', 'chartData', 'labels'));
    }

    public function tampilAlumni() 
    {
        $users = User::where('role', 'alumni')->get();
        return view('admin.tampilAlumni', compact('users'));
    }

    function tambahAlumni()
    {
        return view('admin.tambahAlumni');
    }

    function simpanAlumni(Request $request){

        $data = User::create([
            'nomor_nia'=>$request->nomor_nia,
            'username'=>$request->username,
            'tahun_masuk'=>$request->tahun_masuk,
            'tahun_tamat'=>$request->tahun_tamat,
            'role'=> 'alumni'
        ]);

    Session::flash('pesan','Data Berhasil Tersimpan!');
    return redirect('alumni/tampil');
    }

    function hapusAlumni($id_user){
        $users = User::where('id_user',$id_user)
        ->delete();
        Session::flash('pesan','Data Berhasil Dihapus!');

        return redirect('alumni/tampil');
    }

    function editAlumni($id_user){
        $users = User::select('*')
            ->where('id_user',$id_user)
            ->first();
        
        return view('admin.editAlumni',compact('users'));
    }

    function updateAlumni(Request $request)
    {
        $users = User::where('id_user',$request->id_user)
        ->update([
            'nomor_nia'=>$request->nomor_nia,
            'username'=>$request->username,
            'nama'=>$request->nama,
            'pekerjaan'=>$request->pekerjaan,
            'email'=>$request->email,
            'lokasi'=>$request->lokasi,
            'tahun_masuk'=>$request->tahun_masuk,
            'tahun_tamat'=>$request->tahun_tamat
        ]);

        Session::flash('pesan','Data Anda Telah Berhasil Kami Edit!!!');

        return redirect('alumni/tampil');
    }

    // METHOD UNTUK MANAJEMEN KOMENTAR ALUMNI
    public function komentarAlumni()
    {
        // Ambil semua komentar tanpa paginasi (semua data)
        $comments = Comment::with(['user', 'target', 'replies'])
            ->whereNull('parent_id') // Hanya komentar utama, bukan balasan
            ->latest()
            ->get();

        return view('admin.komentarAlumni', compact('comments'));
    }

    public function approve($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->admin_status = 'approved';
            $comment->save();
            
            Session::flash('success', 'Komentar berhasil disetujui!');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menyetujui komentar: ' . $e->getMessage());
        }
        
        return back();
    }

    public function reject($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->admin_status = 'rejected';
            $comment->save();
            
            Session::flash('success', 'Komentar berhasil ditolak!');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menolak komentar: ' . $e->getMessage());
        }
        
        return back();
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete(); // Akan menghapus balasan juga karena cascade
        
        Session::flash('success', 'Komentar berhasil dihapus!');
        return back();
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'balasan' => 'required|string|max:1000'
        ]);

        $parent = Comment::findOrFail($id);

        Comment::create([
            'user_id' => auth()->user()->id_user, // Admin yang membalas
            'target_user_id' => $parent->user_id, // Balas ke si alumni
            'content' => $request->balasan,
            'parent_id' => $id,
            'admin_status' => 'approved', // Balasan admin langsung approved
            'mudir_status' => 'approved', // Balasan admin langsung approved
            'rating' => null, // Balasan tidak punya rating
        ]);

        Session::flash('success', 'Balasan berhasil dikirim!');
        return back();
    }


    // ========================================================
    // MANAJEMEN EVENT
    // ========================================================
    
    public function daftarEvent()
    {
        $events = \App\Models\Event::with('user')->orderBy('date', 'desc')->get();
        
        // Hitung statistik
        $totalEvents = \App\Models\Event::count();
        
        $upcomingEvents = \App\Models\Event::where('date', '>', now()->toDateString())
            ->orWhere(function($q) {
                $q->where('date', '=', now()->toDateString())
                  ->where('time', '>=', now()->toTimeString());
            })->count();
        
        $pastEvents = \App\Models\Event::where('date', '<', now()->toDateString())
            ->orWhere(function($q) {
                $q->where('date', '=', now()->toDateString())
                  ->where('time', '<', now()->toTimeString());
            })->count();
        
        $byCategory = \App\Models\Event::select('category', \DB::raw('count(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();
        
        $stats = [
            'total' => $totalEvents,
            'upcoming' => $upcomingEvents,
            'past' => $pastEvents,
            'by_category' => $byCategory
        ];
        
        return view('admin.daftarEvent', compact('events', 'stats'));
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
            Session::flash('success', 'Event berhasil ditambahkan!');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menyimpan event: ' . $e->getMessage());
        }

        return redirect()->route('admin.event.index');
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
            // Hapus gambar lama
            if ($event->image) {
                \Storage::disk('public')->delete($event->image);
            }
            $imagePath = $request->file('image')->store('events', 'public');
            $data['image'] = $imagePath;
        }

        try {
            $event->update($data);
            Session::flash('success', 'Event berhasil diperbarui!');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal memperbarui event: ' . $e->getMessage());
        }

        return redirect()->route('admin.event.index');
    }

    public function destroyEvent($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        
        if ($event->image) {
            \Storage::disk('public')->delete($event->image);
        }
        
        $event->delete();
        
        Session::flash('success', 'Event berhasil dihapus!');
        return redirect()->route('admin.event.index');
    }

    public function tampilPendaftarEvent($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        $participants = $event->participants()->orderBy('event_user.created_at', 'desc')->get();
        return view('admin.tampilPendaftarEvent', compact('event', 'participants'));
    }


    // ========================================================
    // MANAJEMEN INFO PONDOK
    // ========================================================
    
    public function tampilInfoPondok()
    {
        $info_pondok = \App\Models\InfoPondok::latest()->get();
        return view('admin.info.index', compact('info_pondok'));
    }

    public function tambahInfoPondok()
    {
        return view('admin.info.create');
    }

    public function simpanInfoPondok(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'jenis' => 'required|in:Pengumuman,Kegiatan,Pengembangan',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $input = $request->all();

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('info_pondok', 'public');
            $input['gambar'] = $path;
        }

        \App\Models\InfoPondok::create($input);

        Session::flash('pesan', 'Info Pondok berhasil ditambahkan!');
        return redirect()->route('admin.info.index');
    }
    
    public function editInfoPondok($id)
    {
        $info = \App\Models\InfoPondok::findOrFail($id);
        return view('admin.info.edit', compact('info'));
    }

    public function updateInfoPondok(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'jenis' => 'required|in:Pengumuman,Kegiatan,Pengembangan',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $info = \App\Models\InfoPondok::findOrFail($id);
        $input = $request->except(['gambar', '_token', '_method']);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('info_pondok', 'public');
            $input['gambar'] = $path;
        }

        $info->update($input);

        Session::flash('pesan', 'Info Pondok berhasil diperbarui!');
        return redirect()->route('admin.info.index');
    }

    public function hapusInfoPondok($id)
    {
        $info = \App\Models\InfoPondok::findOrFail($id);
        $info->delete();
        Session::flash('pesan', 'Info Pondok berhasil dihapus!');
        return back();
    }

    // ========================================================
    // MANAJEMEN KONTAK USTADZ
    // ========================================================
    
    public function tampilKontakUstadz()
    {
        $ustadzs = KontakUstadz::all();
        return view('admin.kontak.index', compact('ustadzs'));
    }

    public function tambahKontakUstadz()
    {
        return view('admin.kontak.create');
    }

    public function simpanKontakUstadz(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $input = $request->all();

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('kontak_ustadz', 'public');
            $input['foto'] = $path;
        }

        KontakUstadz::create($input);

        Session::flash('pesan', 'Kontak Ustadz berhasil ditambahkan!');
        return redirect()->route('admin.kontak.index');
    }

    public function editKontakUstadz($id)
    {
        $ustadz = KontakUstadz::findOrFail($id);
        return view('admin.kontak.edit', compact('ustadz'));
    }

    public function updateKontakUstadz(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $ustadz = KontakUstadz::findOrFail($id);
        $input = $request->except(['foto', '_token', '_method']);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('kontak_ustadz', 'public');
            $input['foto'] = $path;
        }

        $ustadz->update($input);

        Session::flash('pesan', 'Data Ustadz berhasil diperbarui!');
        return redirect()->route('admin.kontak.index');
    }

    public function hapusKontakUstadz($id)
    {
        $ustadz = KontakUstadz::findOrFail($id);
        $ustadz->delete();
        Session::flash('pesan', 'Data Ustadz berhasil dihapus!');
        return back();
    }

    // ========================================================
    // MANAJEMEN FAQ
    // ========================================================

    public function tampilFaq()
    {
        $faqs = \App\Models\Faq::orderBy('order')->get();
        return view('admin.faq.index', compact('faqs'));
    }

    public function tambahFaq()
    {
        return view('admin.faq.create');
    }

    public function simpanFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'order' => 'nullable|integer'
        ]);

        \App\Models\Faq::create($request->all());

        Session::flash('pesan', 'FAQ berhasil ditambahkan!');
        return redirect()->route('admin.faq.index');
    }

    public function editFaq($id)
    {
        $faq = \App\Models\Faq::findOrFail($id);
        return view('admin.faq.edit', compact('faq'));
    }

    public function updateFaq(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'order' => 'nullable|integer'
        ]);

        $faq = \App\Models\Faq::findOrFail($id);
        $faq->update($request->all());

        Session::flash('pesan', 'FAQ berhasil diperbarui!');
        return redirect()->route('admin.faq.index');
    }

    public function hapusFaq($id)
    {
        $faq = \App\Models\Faq::findOrFail($id);
        $faq->delete();
        Session::flash('pesan', 'FAQ berhasil dihapus!');
        return back();
    }

    // ========================================================
    // MANAJEMEN PESAN KONTAK
    // ========================================================

    public function tampilPesanKontak()
    {
        $pesans = \App\Models\ContactMessage::with('user')->latest()->get();
        return view('admin.pesan.index', compact('pesans'));
    }

    public function balasPesanKontak(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string'
        ]);

        $pesan = \App\Models\ContactMessage::findOrFail($id);
        $pesan->admin_reply = $request->reply;
        $pesan->replied_at = now();
        $pesan->status = 'read';
        $pesan->save();

        Session::flash('pesan', 'Balasan berhasil dikirim!');
        return back();
    }

    public function bukaLampiran($id)
    {
        $pesan = \App\Models\ContactMessage::findOrFail($id);
        
        // Tandai sebagai dibaca jika belum
        if ($pesan->status == 'unread') {
            $pesan->status = 'read';
            $pesan->save();
        }

        if (!$pesan->attachment) {
            return back()->with('error', 'Lampiran tidak ditemukan.');
        }

        return redirect(asset('storage/' . $pesan->attachment));
    }

    public function hapusBalasan($id)
    {
        $pesan = \App\Models\ContactMessage::findOrFail($id);
        $pesan->admin_reply = null;
        $pesan->replied_at = null;
        // Opsional: Jika ingin status balik ke unread jika tidak ada balasan sama sekali, 
        // tapi biasanya pesan sudah "dibaca" meskipun balasannya dihapus.
        $pesan->save();

        Session::flash('pesan', 'Balasan berhasil dihapus!');
        return back();
    }

    public function tandaiDibaca($id)
    {
        $pesan = \App\Models\ContactMessage::findOrFail($id);
        $pesan->status = 'read';
        $pesan->save();

        Session::flash('pesan', 'Pesan ditandai sebagai dibaca.');
        return back();
    }

    public function hapusPesanKontak($id)
    {
        $pesan = \App\Models\ContactMessage::findOrFail($id);
        
        // Hapus lampiran jika ada
        if ($pesan->attachment) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($pesan->attachment);
        }

        $pesan->delete();

        Session::flash('pesan', 'Pesan masuk berhasil dihapus!');
        return back();
    }

    // ========================================================
    // KELOLA AKUN ADMIN
    // ========================================================
    
    public function akunAdmin()
    {
        $user = auth()->user();
        
        // Statistik Sistem untuk Admin
        $totalAlumni = User::where('role', 'alumni')->count();
        $totalEvents = \App\Models\Event::count();
        $totalMessages = \App\Models\ContactMessage::count();
        
        return view('admin.akunAdmin', compact('user', 'totalAlumni', 'totalEvents', 'totalMessages'));
    }

    public function updateAkunAdmin(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'angkatan' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'bio' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->tahun_masuk = $request->tahun_masuk;
        $user->tahun_tamat = $request->tahun_tamat;
        $user->no_hp = $request->no_hp;
        $user->pekerjaan = $request->pekerjaan;
        $user->lokasi = $request->lokasi;
        $user->alamat = $request->alamat;
        $user->bio = $request->bio;

        if ($request->hasFile('foto')) {
            if ($user->foto && \Storage::exists('public/' . $user->foto)) {
                \Storage::delete('public/' . $user->foto);
            }
            $path = $request->file('foto')->store('uploads/admin', 'public');
            $user->foto = $path;
            $user->profile = $path;
        }

        $user->save();

        Session::flash('success', 'Profil admin berhasil diperbarui!');
        return back();
    }

    public function updatePasswordAdmin(Request $request)
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

        Session::flash('success', 'Kata sandi admin berhasil diperbarui!');
        return back();
    }

    public function globalSearch(Request $request)
    {
        $query = $request->get('q');
        if (empty($query)) {
            return response()->json(['results' => []]);
        }

        $results = [];

        // 1. Cari Alumni
        $alumni = User::where('role', 'alumni')
            ->where(function($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%")
                  ->orWhere('nomor_nia', 'LIKE', "%{$query}%")
                  ->orWhere('username', 'LIKE', "%{$query}%");
            })
            ->limit(5)
            ->get();

        foreach ($alumni as $a) {
            $results[] = [
                'type' => 'Alumni',
                'title' => $a->nama,
                'subtitle' => "NIA: {$a->nomor_nia} | Tahun: {$a->tahun_masuk}-{$a->tahun_tamat}",
                'url' => route('admin.alumni.edit', $a->id_user),
                'icon' => 'dw-user1'
            ];
        }

        // 2. Cari Event
        $events = \App\Models\Event::where('title', 'LIKE', "%{$query}%")
            ->limit(3)
            ->get();

        foreach ($events as $e) {
            $results[] = [
                'type' => 'Event',
                'title' => $e->title,
                'subtitle' => date('d M Y', strtotime($e->date)),
                'url' => route('admin.event.index'), // Bisa diarahkan ke detail jika ada
                'icon' => 'dw-calendar1'
            ];
        }

        // 3. Cari Info Pondok
        $infos = \App\Models\InfoPondok::where('judul', 'LIKE', "%{$query}%")
            ->limit(3)
            ->get();

        foreach ($infos as $i) {
            $results[] = [
                'type' => 'Info',
                'title' => $i->judul,
                'subtitle' => $i->jenis,
                'url' => route('admin.info.index'),
                'icon' => 'dw-paper-plane'
            ];
        }

        return response()->json(['results' => $results]);
    }

    public function approveEvent($id)
    {
        try {
            $event = \App\Models\Event::findOrFail($id);
            $event->status_admin = 'approved';
            $event->save();

            return back()->with('success', 'Event berhasil disetujui oleh Admin!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyetujui event: ' . $e->getMessage());
        }
    }

    public function rejectEvent($id)
    {
        try {
            $event = \App\Models\Event::findOrFail($id);
            $event->status_admin = 'rejected';
            $event->save();

            return back()->with('success', 'Event berhasil ditolak oleh Admin!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menolak event: ' . $e->getMessage());
        }
    }
}
