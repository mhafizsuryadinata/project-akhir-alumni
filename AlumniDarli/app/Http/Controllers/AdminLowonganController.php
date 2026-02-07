<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Lamaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminLowonganController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Lowongan::count(),
            'aktif' => Lowongan::where('status', 'Aktif')->where('tanggal_tutup', '>=', now())->count(),
            'tutup' => Lowongan::where('status', 'Ditutup')->orWhere('tanggal_tutup', '<', now())->count(),
        ];

        $lowongan = Lowongan::withCount('lamaran')
            ->with('poster')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.lowongan.index', compact('stats', 'lowongan'));
    }

    public function store(Request $request)
    {
        $request->validate([
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
            'tanggal_tutup' => 'required|date|after:today',
            'logo_perusahaan' => 'nullable|image|max:2048',
            'level' => 'required|in:Entry Level,Mid Level,Senior Level,Manager,Director'
        ]);

        $logoPath = null;
        if ($request->hasFile('logo_perusahaan')) {
            $logoPath = $request->file('logo_perusahaan')->store('uploads/company_logos', 'public');
        }

        Lowongan::create([
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
            'posted_by' => Auth::user()->id_user ?? 0,
            'status_admin' => 'approved',
        ]);

        return redirect()->back()->with('success', 'Lowongan berhasil dibuat!');
    }

    public function show($id)
    {
        $lowongan = Lowongan::with(['lamaran.user', 'poster'])->findOrFail($id);
        
        $stats = [
            'total_pelamar' => $lowongan->lamaran->count(),
            'hari_sisa' => now()->diffInDays($lowongan->tanggal_tutup, false)
        ];

        return view('admin.lowongan.show', compact('lowongan', 'stats'));
    }

    public function update(Request $request, $id)
    {
        $lowongan = Lowongan::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'tipe_pekerjaan' => 'required|string',
            'lokasi' => 'required|string',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'email_kontak' => 'required|email',
            'tanggal_tutup' => 'required|date',
            'status' => 'required|in:Aktif,Ditutup,Draft',
            'level' => 'required|in:Entry Level,Mid Level,Senior Level,Manager,Director',
            'logo_perusahaan' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('logo_perusahaan')) {
            if ($lowongan->logo_perusahaan && Storage::disk('public')->exists($lowongan->logo_perusahaan)) {
                Storage::disk('public')->delete($lowongan->logo_perusahaan);
            }
            $lowongan->logo_perusahaan = $request->file('logo_perusahaan')->store('uploads/company_logos', 'public');
        }

        $lowongan->update([
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
            'level' => $request->level,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Lowongan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $lowongan = Lowongan::findOrFail($id);

        // Delete logo
        if ($lowongan->logo_perusahaan && Storage::disk('public')->exists($lowongan->logo_perusahaan)) {
            Storage::disk('public')->delete($lowongan->logo_perusahaan);
        }

        // Delete CVs associated with this job
        foreach ($lowongan->lamaran as $lamaran) {
            if ($lamaran->cv_path && Storage::disk('public')->exists($lamaran->cv_path)) {
                Storage::disk('public')->delete($lamaran->cv_path);
            }
        }
        
        $lowongan->lamaran()->delete();
        $lowongan->delete();

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil dihapus!');
    }

    public function downloadCv($id)
    {
        $lamaran = Lamaran::findOrFail($id);
        
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

        $lamaran = Lamaran::findOrFail($id);
        $lamaran->update([
            'status_admin' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status lamaran berhasil diperbarui oleh Admin!');
    }

    public function approveLowongan($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->update(['status_admin' => 'approved']);
        return back()->with('success', 'Lowongan berhasil disetujui Admin!');
    }

    public function rejectLowongan($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->update(['status_admin' => 'rejected']);
        return back()->with('success', 'Lowongan berhasil ditolak Admin!');
    }
}
