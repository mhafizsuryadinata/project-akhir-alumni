<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Lamaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LowonganController extends Controller
{
    // Menampilkan daftar lowongan
    public function index(Request $request)
    {
        $lowongan = Lowongan::where(function($query) {
                $query->where(function($q) {
                    $q->active()
                      ->where('status_admin', 'approved')
                      ->where('status_pimpinan', 'approved');
                })->orWhere('posted_by', Auth::check() ? Auth::user()->id_user : null);
            })
            ->latest()
            ->get();
        
        // Data untuk filter dropdown
        $tipeList = ['Full Time', 'Part Time', 'Freelance', 'Contract', 'Internship'];
        $levelList = ['Entry Level', 'Mid Level', 'Senior Level', 'Manager', 'Director'];
        $lokasiList = Lowongan::select('lokasi')->distinct()->pluck('lokasi');
        
        $totalLowongan = Lowongan::active()->where('status_admin', 'approved')->where('status_pimpinan', 'approved')->count();
        
        return view('alumni.lowongan.index', compact('lowongan', 'tipeList', 'levelList', 'lokasiList', 'totalLowongan'));
    }

    // Menampilkan detail lowongan
    public function show($id)
    {
        $lowongan = Lowongan::with(['lamaran.user'])
            ->where('id', $id)
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('status_admin', 'approved')
                      ->where('status_pimpinan', 'approved');
                })->orWhere('posted_by', Auth::check() ? Auth::user()->id_user : null);
            })
            ->firstOrFail();
        
        // Cek apakah user sudah apply
        $sudahApply = false;
        if (Auth::check()) {
            $sudahApply = Lamaran::where('lowongan_id', $id)
                                 ->where('user_id', Auth::user()->id_user)
                                 ->exists();
        }
        
        // Lowongan terkait (dari perusahaan yang sama atau tipe pekerjaan yang sama)
        $lowonganTerkait = Lowongan::active()
            ->where('status_admin', 'approved')
            ->where('status_pimpinan', 'approved')
            ->where('id', '!=', $id)
            ->where(function($q) use ($lowongan) {
                $q->where('perusahaan', $lowongan->perusahaan)
                  ->orWhere('tipe_pekerjaan', $lowongan->tipe_pekerjaan);
            })
            ->limit(3)
            ->get();
        
        return view('alumni.lowongan.show', compact('lowongan', 'sudahApply', 'lowonganTerkait'));
    }

    // Form tambah lowongan (admin/alumni)
    public function create()
    {
        return view('alumni.lowongan.create');
    }

    // Simpan lowongan baru
    public function store(Request $request)
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
        
        // Upload logo perusahaan jika ada
        if ($request->hasFile('logo_perusahaan')) {
            $path = $request->file('logo_perusahaan')->store('lowongan/logos', 'public');
            $data['logo_perusahaan'] = 'storage/' . $path;
        }
        
        $data['posted_by'] = Auth::check() ? Auth::user()->id_user : null;
        $data['status'] = 'Aktif';
        
        Lowongan::create($data);
        
        return redirect()->route('lowongan.index')->with('success', 'Berhasil, menunggu persetujuan dari admin dan pimpinan baru akan tampil.');
    }

    // Form edit lowongan
    public function edit($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        
        // Cek apakah user berhak mengedit
        if (Auth::check() && (Auth::user()->role === 'admin' || $lowongan->posted_by === Auth::user()->id_user)) {
            return view('alumni.lowongan.edit', compact('lowongan'));
        }
        
        return redirect()->route('lowongan.index')->with('error', 'Anda tidak memiliki akses untuk mengedit lowongan ini.');
    }

    // Update lowongan
    public function update(Request $request, $id)
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
        
        // Upload logo baru jika ada
        if ($request->hasFile('logo_perusahaan')) {
            // Hapus logo lama
            if ($lowongan->logo_perusahaan) {
                Storage::disk('public')->delete(str_replace('storage/', '', $lowongan->logo_perusahaan));
            }
            
            $path = $request->file('logo_perusahaan')->store('lowongan/logos', 'public');
            $data['logo_perusahaan'] = 'storage/' . $path;
        }
        
        $lowongan->update($data);
        
        return redirect()->route('lowongan.show', $id)->with('success', 'Lowongan berhasil diperbarui!');
    }

    // Hapus lowongan
    public function destroy($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        
        // Hapus logo jika ada
        if ($lowongan->logo_perusahaan) {
            Storage::disk('public')->delete(str_replace('storage/', '', $lowongan->logo_perusahaan));
        }
        
        $lowongan->delete();
        
        return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil dihapus!');
    }

    // Apply lowongan
    public function apply(Request $request, $id)
    {
        $request->validate([
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|string',
        ]);

        // Cek apakah sudah pernah apply
        $existingLamaran = Lamaran::where('lowongan_id', $id)
                                  ->where('user_id', Auth::user()->id_user)
                                  ->first();
        
        if ($existingLamaran) {
            return back()->with('error', 'Anda sudah melamar untuk lowongan ini.');
        }

        $data = [
            'lowongan_id' => $id,
            'user_id' => Auth::user()->id_user,
            'cover_letter' => $request->cover_letter,
            'status' => 'Pending',
        ];
        
        // Upload CV jika ada
        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('lamaran/cv', 'public');
            $data['cv_path'] = 'storage/' . $path;
        }
        
        Lamaran::create($data);
        
        return back()->with('success', 'Lamaran Anda berhasil dikirim!');
    }

    // Daftar lamaran saya
    public function myApplications()
    {
        // Jika belum login, redirect ke login dengan pesan
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu untuk melihat lamaran Anda.');
        }
        
        $lamaran = Lamaran::with('lowongan')
                          ->where('user_id', Auth::user()->id_user)
                          ->latest()
                          ->paginate(10);
        
        return view('alumni.lowongan.my-applications', compact('lamaran'));
    }
}
