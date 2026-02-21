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
            $userData = $user->toArray();
            
            // Ensure foto and profile are full URLs for Android consistency
            if ($user->foto && !str_starts_with($user->foto, 'http')) {
                // If path starts with storage/, don't double it
                $path = str_starts_with($user->foto, 'storage/') ? $user->foto : 'storage/' . $user->foto;
                $userData['foto'] = asset($path);
            }
            if ($user->profile && !str_starts_with($user->profile, 'http')) {
                $path = str_starts_with($user->profile, 'storage/') ? $user->profile : 'storage/' . $user->profile;
                $userData['profile'] = asset($path);
            }

            return response()->json([
                'response_code' => 200,
                'message' => 'Login berhasil sebagai Alumni',
                'content' => $userData
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
        // Trim inputs to avoid validation errors from trailing spaces
        if ($request->has('email')) {
            $request->merge(['email' => trim($request->email)]);
        }

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
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
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
            // Simpan di folder storage/app/public/uploads/profile
            $file->move(storage_path('app/public/uploads/profile'), $filename);
            $user->foto = 'uploads/profile/' . $filename;
        }

        $user->save();

        $userData = [
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

        return response()->json([
            'response_code' => 200,
            'message' => 'Profil berhasil diperbarui',
            'content' => $userData
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
                'user_photo' => $comment->user->foto ? (str_starts_with($comment->user->foto, 'http') ? $comment->user->foto : asset('storage/' . $comment->user->foto)) : null,
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

    public function getAlbums()
    {
        $albums = \DB::table('album')
            ->where('status_admin', 'approved')
            ->where('status_pimpinan', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        $data = $albums->map(function($album) {
            $photoCount = \DB::table('galeri')
                ->where('album_id', $album->id)
                ->whereIn('tipe', ['foto', 'photo'])
                ->where('status_admin', 'approved')
                ->where('status_pimpinan', 'approved')
                ->count();

            $videoCount = \DB::table('galeri')
                ->where('album_id', $album->id)
                ->where('tipe', 'video')
                ->where('status_admin', 'approved')
                ->where('status_pimpinan', 'approved')
                ->count();

            $coverUrl = null;
            if ($album->cover) {
                $coverUrl = str_starts_with($album->cover, 'http')
                    ? $album->cover
                    : (str_starts_with($album->cover, 'storage/')
                        ? asset($album->cover)
                        : asset('storage/' . $album->cover));
            }

            return [
                'id' => $album->id,
                'nama_album' => $album->nama_album,
                'deskripsi' => $album->deskripsi,
                'tahun' => $album->tahun,
                'kategori' => $album->kategori,
                'cover_url' => $coverUrl,
                'photo_count' => $photoCount,
                'video_count' => $videoCount,
            ];
        });

        return response()->json([
            'response_code' => 200,
            'content' => $data
        ]);
    }

    public function getAlbumMedia(Request $request, $id)
    {
        $id_user = $request->query('id_user');
        
        $media = \DB::table('galeri')
            ->where('album_id', $id)
            ->where(function($query) use ($id_user) {
                $query->where(function($q) {
                    $q->where('status_admin', 'approved')
                      ->where('status_pimpinan', 'approved');
                });
                if ($id_user) {
                    $query->orWhere('uploaded_by', $id_user);
                }
            })
            ->latest()
            ->get();

        return response()->json([
            'response_code' => 200,
            'content' => $media->map(function($item) {
                return [
                    'id' => $item->id,
                    'album_id' => $item->album_id,
                    'file_path' => asset('storage/' . $item->file_path),
                    'tipe' => $item->tipe,
                    'deskripsi' => $item->deskripsi,
                    'status_admin' => $item->status_admin,
                    'status_pimpinan' => $item->status_pimpinan,
                    'created_at' => $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y') : '-'
                ];
            })
        ]);
    }

    public function storeMedia(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'album_id' => 'required|exists:album,id',
            'id_user' => 'required|exists:users,id_user',
            'tipe' => 'required|in:foto,photo,video',
            'file' => 'required|file|max:20480', // 20MB
            'deskripsi' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response_code' => 400,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ]);
        }

        $file = $request->file('file');
        $path = $file->store('galeri/' . $request->album_id, 'public');

        $media = \App\Models\Galeri::create([
            'album_id' => $request->album_id,
            'file_path' => $path,
            'tipe' => $request->tipe,
            'deskripsi' => $request->deskripsi,
            'uploaded_by' => $request->id_user,
            'status_admin' => 'pending',
            'status_pimpinan' => 'pending'
        ]);

        return response()->json([
            'response_code' => 200,
            'message' => 'Media berhasil diupload dan menunggu persetujuan',
            'content' => $media
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

    public function getEvents(Request $request)
    {
        $id_user = $request->input('id_user');

        $query = \App\Models\Event::query();

        // If user_id provided, show approved AND own pending events
        if ($id_user) {
            $query->where(function($q) use ($id_user) {
                $q->where(function($sub) {
                    $sub->where('status_admin', 'approved')
                        ->where('status_pimpinan', 'approved');
                })->orWhere('user_id', $id_user);
            });
        } else {
            // General public / guest: show only approved
            $query->where('status_admin', 'approved')
                  ->where('status_pimpinan', 'approved');
        }

        $events = $query->latest('date')->get();

        return response()->json([
            'response_code' => 200,
            'content' => $events->map(function($item) use ($id_user) {
                $is_joined = false;
                if ($id_user) {
                    // Check pivot table
                    $is_joined = \DB::table('event_user')
                        ->where('event_id', $item->id)
                        ->where('user_id', $id_user)
                        ->exists();
                }

                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'category' => $item->category,
                    'date' => $item->date ? \Carbon\Carbon::parse($item->date)->format('d M Y') : '-',
                    'raw_date' => $item->date, // For sorting/filtering in app
                    'time' => $item->time,
                    'location' => $item->location,
                    'description' => $item->description,
                    'image' => $item->image ? asset('storage/' . $item->image) : null,
                    'status' => $item->status, // 'upcoming', 'finished' etc based on date (or database column if exists)
                    'user_id' => $item->user_id,
                    'creator_name' => $item->user->nama ?? 'Admin',
                    'is_joined' => $is_joined,
                    'status_admin' => $item->status_admin,
                    'status_pimpinan' => $item->status_pimpinan,
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

    public function storeLowongan(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'tipe_pekerjaan' => 'required|string',
            'lokasi' => 'required|string',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'benefit' => 'nullable|string',
            'gaji_min' => 'nullable|numeric',
            'gaji_max' => 'nullable|numeric',
            'email_kontak' => 'required|email',
            'website' => 'nullable|url',
            'tanggal_tutup' => 'required|date',
            'logo_perusahaan' => 'nullable|image|max:2048',
            'level' => 'required|in:Entry Level,Mid Level,Senior Level,Manager,Director',
            'posted_by' => 'required|exists:users,id_user'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response_code' => 400,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ]);
        }

        $logoPath = null;
        if ($request->hasFile('logo_perusahaan')) {
            $logoPath = $request->file('logo_perusahaan')->store('uploads/company_logos', 'public');
        }

        $lowongan = \App\Models\Lowongan::create([
            'judul' => $request->judul,
            'perusahaan' => $request->perusahaan,
            'tipe_pekerjaan' => $request->tipe_pekerjaan,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'kualifikasi' => $request->kualifikasi,
            'benefit' => $request->benefit,
            'gaji_min' => $request->gaji_min,
            'gaji_max' => $request->gaji_max,
            'email_kontak' => $request->email_kontak,
            'website' => $request->website,
            'tanggal_tutup' => $request->tanggal_tutup,
            'logo_perusahaan' => $logoPath,
            'level' => $request->level,
            'status' => 'Aktif',
            'posted_by' => $request->posted_by,
            'status_admin' => 'pending', // Alumni postings need approval
            'status_pimpinan' => 'pending'
        ]);

        return response()->json([
            'response_code' => 200,
            'message' => 'Lowongan berhasil dibuat dan menunggu persetujuan Admin!',
            'content' => $lowongan
        ]);
    }
    public function joinEvent(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id_user',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response_code' => 400,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::find($request->user_id);
        $event = \App\Models\Event::find($request->event_id);

        // Check if already joined
        $exists = \DB::table('event_user')
            ->where('event_id', $event->id)
            ->where('user_id', $user->id_user)
            ->exists();

        if ($exists) {
            return response()->json([
                'response_code' => 400,
                'message' => 'Anda sudah terdaftar di acara ini.'
            ]);
        }

        // Attach user to event
        \DB::table('event_user')->insert([
            'event_id' => $event->id,
            'user_id' => $user->id_user,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'response_code' => 200,
            'message' => 'Berhasil mendaftar acara!'
        ]);
    }
    public function storeEvent(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'id_user' => 'required|exists:users,id_user',
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string', // Consider validating time format H:i
            'location' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response_code' => 400,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ]);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        $event = \App\Models\Event::create([
            'user_id' => $request->id_user,
            'title' => $request->title,
            'category' => $request->category,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => 'upcoming',
            'status_admin' => 'pending',
            'status_pimpinan' => 'pending'
        ]);

        return response()->json([
            'response_code' => 200,
            'message' => 'Event berhasil dibuat dan menunggu persetujuan Admin!',
            'content' => $event
        ]);
    }
    public function update_photo(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'id_user' => 'required|exists:users,id_user',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response_code' => 400,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::find($request->id_user);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Simpan di folder storage/app/public/uploads/profile
            $file->move(storage_path('app/public/uploads/profile'), $filename);
            $user->foto = 'uploads/profile/' . $filename;
            $user->save();

            $userData = [
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
            
            return response()->json([
                'response_code' => 200,
                'message' => 'Foto profil berhasil diperbarui',
                'content' => $userData
            ]);
        }

        return response()->json([
            'response_code' => 400,
            'message' => 'File tidak ditemukan'
        ]);
    }

}
