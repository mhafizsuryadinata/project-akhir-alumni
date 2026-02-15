<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'username'    => 'required|string',
            'nomor_nia'  => 'required|string',
        ]);

        // 2. Cari user berdasarkan username + NIA
        $user = User::where('username', $request->username)
                    ->where('nomor_nia', $request->nomor_nia)
                    ->first();

        // 3. Jika user tidak ditemukan
        if (!$user) {
            return response()->json([
                'response_code' => 404,
                'message' => 'Username atau NIA salah!'
            ]);
        }

        // 4. Login manual TANPA password
        Auth::login($user);

        // 5. Redirect berdasarkan role
        if ($user->role === 'admin') {
            return response()->json([
                'response_code' => 200,
                'message' => 'Login berhasil sebagai Admin',
                'redirect' => route('admin.dashboard'),
                'content' => $user
            ]);
        }

        if ($user->role === 'alumni') {
            // Pastikan is_complete dikirim
            return response()->json([
                'response_code' => 200,
                'message' => 'Login berhasil sebagai Alumni',
                'content' => $user
            ]);
        }

        // 6. Role tidak valid
        return response()->json([
            'response_code' => 403,
            'message' => 'Role tidak dikenali!'
        ]);
    }

    public function update_profile(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'id_user' => 'required|exists:users,id_user',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'pekerjaan' => 'required|string',
            'lokasi' => 'required|string',
            'email' => 'required|email',
            'bio' => 'nullable|string|max:2000',
            'instagram' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'pendidikan_lanjutan' => 'nullable|string',
            'tahun_masuk' => 'nullable|string',
            'tahun_tamat' => 'nullable|string',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response_code' => 400,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::find($request->id_user);

        if (!$user) {
            return response()->json([
                'response_code' => 404,
                'message' => 'User tidak ditemukan'
            ]);
        }

        $user->nama = $request->nama;
        $user->alamat = $request->alamat;
        $user->no_hp = $request->no_hp;
        $user->pekerjaan = $request->pekerjaan;
        $user->lokasi = $request->lokasi;
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->instagram = $request->instagram;
        $user->linkedin = $request->linkedin;
        $user->pendidikan_lanjutan = $request->pendidikan_lanjutan;
        $user->tahun_masuk = $request->tahun_masuk;
        $user->tahun_tamat = $request->tahun_tamat;
        $user->is_complete = 1; // Tandai profil sudah lengkap

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Simpan di folder public/uploads/profile
            $file->move(public_path('uploads/profile'), $filename);
            $user->foto = 'uploads/profile/' . $filename;
        }

        $user->save();

        return response()->json([
            'response_code' => 200,
            'message' => 'Profil berhasil diperbarui',
            'content' => $user
        ]);
    }

    public function alumni()
    {
        // Ambil semua user dengan role 'alumni'
        $alumni_list = User::where('role', 'alumni')->get();

        // Transform ke format yang diinginkan Android
        $data = $alumni_list->map(function ($user) {
            return [
                'id' => (string) $user->id_user,
                'name' => $user->nama,
                'batch' => ($user->tahun_masuk ?? '?') . ' - ' . ($user->tahun_tamat ?? '?'),
                'year_in' => (string) $user->tahun_masuk,
                'year_out' => (string) $user->tahun_tamat,
                'profession' => $user->pekerjaan,
                'location' => $user->lokasi,
                'bio' => $user->bio,
                'instagram' => $user->instagram,
                'linkedin' => $user->linkedin,
                'education' => $user->pendidikan_lanjutan,
                'email' => $user->email,
                'contact' => $user->no_hp,
                'address' => $user->alamat,
                'imageUrl' => $user->foto ? asset('storage/' . $user->foto) : null
            ];
        });

        return response()->json($data);
    }

    public function alumniDetail($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'response_code' => 404,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'id' => (string) $user->id_user,
            'name' => $user->nama,
            'batch' => ($user->tahun_masuk ?? '?') . ' - ' . ($user->tahun_tamat ?? '?'),
            'year_in' => (string) $user->tahun_masuk,
            'year_out' => (string) $user->tahun_tamat,
            'profession' => $user->pekerjaan,
            'location' => $user->lokasi,
            'bio' => $user->bio,
            'instagram' => $user->instagram,
            'linkedin' => $user->linkedin,
            'education' => $user->pendidikan_lanjutan,
            'email' => $user->email,
            'contact' => $user->no_hp,
            'address' => $user->alamat,
            'imageUrl' => $user->foto ? asset('storage/' . $user->foto) : null
        ]);
    }

    public function getComments()
    {
        $comments = \App\Models\Comment::with(['user'])
            ->whereNull('parent_id')
            ->where('admin_status', 'approved')
            ->where('mudir_status', 'approved')
            ->where('target_user_id', 0) // 0 for general app comments
            ->latest()
            ->get();

        $data = $comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'user_id' => $comment->user_id,
                'user_name' => $comment->user->nama ?? 'Alumni',
                'user_photo' => $comment->user->foto ?? null,
                'content' => $comment->content,
                'rating' => $comment->rating,
                'status' => $comment->status,
                'admin_reply' => $comment->admin_reply,
                'admin_reply_date' => $comment->admin_reply_date,
                'mudir_reply' => $comment->mudir_reply,
                'mudir_reply_date' => $comment->mudir_reply_date,
                'created_at' => $comment->created_at->format('d M Y'),
                'replies' => $comment->replies->map(function($reply) {
                    return [
                        'user_name' => $reply->user->nama ?? 'Admin',
                        'content' => $reply->content,
                        'created_at' => $reply->created_at->format('d M Y')
                    ];
                })
            ];
        });

        return response()->json([
            'response_code' => 200,
            'content' => $data
        ]);
    }

    public function storeComment(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'id_user' => 'required|exists:users,id_user',
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response_code' => 400,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ]);
        }

        $comment = \App\Models\Comment::create([
            'user_id' => $request->id_user,
            'target_user_id' => 0, // General app comment
            'content' => $request->content,
            'rating' => $request->rating,
            'admin_status' => 'pending',
            'mudir_status' => 'pending',
        ]);

        return response()->json([
            'response_code' => 200,
            'message' => 'Komentar berhasil dikirim dan menunggu persetujuan admin.',
            'content' => $comment
        ]);
    }

    public function deleteComment(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'id' => 'required|exists:comments,id',
            'id_user' => 'required|exists:users,id_user',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response_code' => 400,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ]);
        }

        $comment = \App\Models\Comment::where('id', $request->id)
            ->where('user_id', $request->id_user)
            ->first();

        if (!$comment) {
            return response()->json([
                'response_code' => 403,
                'message' => 'Anda tidak memiliki akses untuk menghapus komentar ini.'
            ]);
        }

        $comment->delete();

        return response()->json([
            'response_code' => 200,
            'message' => 'Komentar berhasil dihapus.'
        ]);
    }

    public function getStats()
    {
        $totalAlumni = User::where('role', 'alumni')->count();
        return response()->json([
            'total_alumni' => $totalAlumni,
            'total_events' => \DB::table('events')->count(),
            'total_announcements' => \DB::table('info_pondok')->count(), // Can serve as 'Events' or 'News'
            'total_teachers' => \DB::table('kontak_ustadzs')->count(),
            'total_jobs' => \DB::table('lowongan')->count()
        ]);
    }

    public function getGaleri()
    {
        // Fetch latest media from galeri_media table (or albums if structure differs)
        // Assuming 'galeri_media' contains file paths
        $data = \DB::table('galeri_media')
            ->join('galeri_albums', 'galeri_media.galeri_album_id', '=', 'galeri_albums.id')
            ->where('galeri_media.status', 'approved')
            ->select('galeri_media.*', 'galeri_albums.nama_album')
            ->latest('galeri_media.created_at')
            ->take(5)
            ->get();

        return response()->json([
            'response_code' => 200,
            'content' => $data->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->caption ?? $item->nama_album, // Use caption if available, else album name
                    'image' => asset('storage/' . $item->file_path),
                    'created_at' => $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y') : '-'
                ];
            })
        ]);
    }

    // --- New Endpoints for Android Dashboard ---

    public function getInfoPondok()
    {
        $data = \DB::table('info_pondok')->latest()->get();
        return response()->json([
            'response_code' => 200,
            'content' => $data->map(function($item) {
                return [
                    'id' => $item->id,
                    'judul' => $item->judul,
                    'konten' => $item->konten,
                    'jenis' => $item->jenis,
                    'gambar' => $item->gambar ? asset('storage/' . $item->gambar) : null,
                    'created_at' => $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y') : '-'
                ];
            })
        ]);
    }

    public function getEvents()
    {
        $data = \DB::table('events')->latest()->get();
        return response()->json([
            'response_code' => 200,
            'content' => $data->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'category' => $item->category,
                    'date' => $item->date ? \Carbon\Carbon::parse($item->date)->format('d M Y') : '-',
                    'time' => $item->time,
                    'location' => $item->location,
                    'description' => $item->description,
                    'image' => $item->image ? asset('storage/' . $item->image) : null,
                    'status' => $item->status
                ];
            })
        ]);
    }

    public function getKontakUstadz()
    {
        $data = \DB::table('kontak_ustadzs')->latest()->get();
        return response()->json([
            'response_code' => 200,
            'content' => $data->map(function($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'jabatan' => $item->jabatan,
                    'bidang' => $item->bidang,
                    'no_hp' => $item->no_hp,
                    'email' => $item->email,
                    'foto' => $item->foto ? asset('storage/' . $item->foto) : null
                ];
            })
        ]);
    }

    public function getLowongan()
    {
        // Removed status filter for broader visibility during testing
        $data = \DB::table('lowongan')->latest()->get();
        return response()->json([
            'response_code' => 200,
            'content' => $data->map(function($item) {
                return [
                    'id' => $item->id,
                    'judul' => $item->judul,
                    'perusahaan' => $item->perusahaan,
                    'lokasi' => $item->lokasi,
                    'tipe_pekerjaan' => $item->tipe_pekerjaan,
                    'gaji' => ($item->gaji_min && $item->gaji_max) ? "Rp " . number_format((float)$item->gaji_min) . " - " . number_format((float)$item->gaji_max) : "kompetitif",
                    'deskripsi' => $item->deskripsi,
                    'kualifikasi' => $item->kualifikasi,
                    'logo' => $item->logo_perusahaan ? asset('storage/' . $item->logo_perusahaan) : null,
                    'email_kontak' => $item->email_kontak,
                    'tanggal_tutup' => $item->tanggal_tutup ? \Carbon\Carbon::parse($item->tanggal_tutup)->format('d M Y') : '-'
                ];
            })
        ]);
    }

    public function applyLowongan(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'lowongan_id' => 'required|exists:lowongan,id',
            'id_user' => 'required|exists:users,id_user',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response_code' => 400,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ]);
        }

        // Cek apakah sudah pernah apply
        $existingLamaran = \App\Models\Lamaran::where('lowongan_id', $request->lowongan_id)
                                  ->where('user_id', $request->id_user)
                                  ->first();
        
        if ($existingLamaran) {
            return response()->json([
                'response_code' => 400,
                'message' => 'Anda sudah melamar untuk lowongan ini.'
            ]);
        }

        $data = [
            'lowongan_id' => $request->lowongan_id,
            'user_id' => $request->id_user,
            'cover_letter' => $request->cover_letter,
            'status' => 'Pending',
            'status_admin' => 'Menunggu',
            'status_pimpinan' => 'Menunggu',
        ];
        
        // Upload CV jika ada
        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('lamaran/cv', 'public');
            $data['cv_path'] = 'storage/' . $path;
        }
        
        \App\Models\Lamaran::create($data);
        
        return response()->json([
            'response_code' => 200,
            'message' => 'Lamaran Anda berhasil dikirim!'
        ]);
    }

    public function getMyApplications($id_user)
    {
        $lamaran = \App\Models\Lamaran::with('lowongan')
            ->where('user_id', $id_user)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'lowongan_id' => $item->lowongan_id,
                    'judul_lowongan' => $item->lowongan->judul,
                    'perusahaan' => $item->lowongan->perusahaan,
                    'logo' => $item->lowongan->logo,
                    'status' => $item->status, // Main status (Pending, Diterima, Ditolak)
                    'status_admin' => $item->status_admin,
                    'status_pimpinan' => $item->status_pimpinan,
                    'final_status' => $item->final_status, // Using the accessor from model
                    'applied_at' => $item->created_at->format('d M Y'),
                ];
            });

        return response()->json([
            'response_code' => 200,
            'message' => 'Berhasil mengambil data lamaran',
            'content' => $lamaran
        ]);
    }
}
