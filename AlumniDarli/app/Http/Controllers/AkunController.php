<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AkunController extends Controller
{
    /**
     * Tampilkan halaman akun.
     */
    public function akun()
    {
        $user = Auth::user();
        
        // 1. Total Event yang diikuti
        $total_events = $user->events()->count();
        
        // 2. Total Koneksi (Alumni lain)
        $total_koneksi = User::where('role', 'alumni')->count() - 1; // Semua alumni minus diri sendiri
        if($total_koneksi < 0) $total_koneksi = 0;

        // 3. Tahun (sejak bergabung/created_at)
        $years_joined = $user->created_at ? $user->created_at->diffInYears(now()) : 0;
        if($years_joined == 0) $years_joined = 1; // Minimal 1 tahun biar gak 0

        // 4. Riwayat Aktivitas (Terbaru 5)
        $activities = $user->events()->orderBy('event_user.created_at', 'desc')->take(5)->get();

        // 5. Default Settings & Privacy jika kosong
        if (!$user->settings) {
            $user->settings = [
                'notifEvents' => true,
                'notifMessages' => true,
                'notifAnnouncements' => false,
                'notifJobs' => true,
                'notifNewsletter' => false,
            ];
            $user->save();
        }
        if (!$user->privacy) {
            $user->privacy = [
                'visibility' => 'public',
                'showEmail' => true,
                'showPhone' => true,
                'showSocial' => true,
                'showActivity' => true,
            ];
            $user->save();
        }

        $settings = $user->settings;
        $privacy = $user->privacy;

        return view('alumni.akun', compact('total_events', 'total_koneksi', 'years_joined', 'activities', 'settings', 'privacy'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        $settings = [
            'notifEvents' => $request->has('notifEvents'),
            'notifMessages' => $request->has('notifMessages'),
            'notifAnnouncements' => $request->has('notifAnnouncements'),
            'notifJobs' => $request->has('notifJobs'),
            'notifNewsletter' => $request->has('notifNewsletter'),
        ];
        $user->settings = $settings;
        $user->save();

        return back()->with('success', 'Pengaturan notifikasi berhasil disimpan!');
    }

    public function updatePrivacy(Request $request)
    {
        $user = Auth::user();
        $privacy = [
            'visibility' => $request->input('visibility', 'public'),
            'showEmail' => $request->has('showEmail'),
            'showPhone' => $request->has('showPhone'),
            'showSocial' => $request->has('showSocial'),
            'showActivity' => $request->has('showActivity'),
        ];
        $user->privacy = $privacy;
        $user->save();

        return back()->with('success', 'Pengaturan privasi berhasil disimpan!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.']);
        }

        $user->password = \Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diperbarui!');
    }

    public function exportData()
    {
        $user = Auth::user();
        $fileName = 'profile_' . $user->username . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'NIA', 'Username', 'Nama', 'Tahun Masuk', 'Tahun Tamat', 'Alamat', 'No HP', 'Pekerjaan', 'Email', 'Lokasi', 'Bio', 'Instagram', 'LinkedIn', 'Pendidikan Lanjutan'];

        $callback = function() use($user, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            fputcsv($file, [
                $user->id_user,
                $user->nomor_nia,
                $user->username,
                $user->nama,
                $user->tahun_masuk,
                $user->tahun_tamat,
                $user->alamat,
                $user->no_hp,
                $user->pekerjaan,
                $user->email,
                $user->lokasi,
                $user->bio,
                $user->instagram,
                $user->linkedin,
                $user->pendidikan_lanjutan,
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Update data akun pengguna.
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'tahun_masuk' => 'nullable|integer',
            'tahun_tamat' => 'nullable|integer',
            'alamat'    => 'required|string',
            'no_hp'     => 'required|string|max:20',
            'pekerjaan' => 'nullable|string|max:255',
            'email'     => 'nullable|email|max:255',
            'lokasi'    => 'nullable|string|max:500',
            'bio'       => 'nullable|string|max:2000',
            'foto'      => 'nullable|image|max:2048',
            'instagram' => 'nullable|string|max:255',
            'linkedin'  => 'nullable|string|max:255',
            'pendidikan_lanjutan' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        // 🔹 Update data teks
        $user->fill([
            'nama'      => $request->nama,
            'tahun_masuk' => $request->tahun_masuk,
            'tahun_tamat' => $request->tahun_tamat,
            'alamat'    => $request->alamat,
            'no_hp'     => $request->no_hp,
            'pekerjaan' => $request->pekerjaan,
            'email'     => $request->email,
            'lokasi'    => $request->lokasi,
            'bio'       => $request->bio,
            'instagram' => $request->instagram,
            'linkedin'  => $request->linkedin,
            'pendidikan_lanjutan' => $request->pendidikan_lanjutan,
        ]);

        // 🔹 Upload foto (otomatis juga jadi profile)
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::exists('public/' . $user->foto)) {
                Storage::delete('public/' . $user->foto);
            }
            if ($user->profile && Storage::exists('public/' . $user->profile)) {
                Storage::delete('public/' . $user->profile);
            }

            // Simpan foto baru
            $path = $request->file('foto')->store('uploads', 'public');
            $user->foto = $path;
            $user->profile = $path; // langsung dijadikan foto profil juga
        }

        $user->is_complete = true;
        $user->save();

        return redirect('alumni')->with('success', 'Biodata berhasil diperbarui!');
    }

    public function updatePhoto(Request $request)
    {
        $user = Auth::user();

        // Jika hapus foto
        if (filter_var($request->input('remove'), FILTER_VALIDATE_BOOLEAN)) {
            if ($user->foto && Storage::exists('public/' . $user->foto)) {
                Storage::delete('public/' . $user->foto);
            }
            if ($user->profile && Storage::exists('public/' . $user->profile)) {
                Storage::delete('public/' . $user->profile);
            }

            $user->foto = null;
            $user->profile = null;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus.',
                'path' => asset('images/default-avatar.png')
            ]);
        }

        // Jika upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($user->foto && Storage::exists('public/' . $user->foto)) {
                Storage::delete('public/' . $user->foto);
            }

            // Simpan foto baru
            $path = $request->file('foto')->store('uploads', 'public');
            $user->foto = $path;
            $user->profile = $path; // <— ini penting agar konsisten
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil diperbarui.',
                'path' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Tidak ada foto yang diupload.']);
    }

    public function removePhoto()
    {
        $user = Auth::user();
        if ($user->foto && Storage::exists('public/' . $user->foto)) {
            Storage::delete('public/' . $user->foto);
        }
        $user->foto = null;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Foto berhasil dihapus.']);
    }
}