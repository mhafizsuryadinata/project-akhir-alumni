<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $albums = Album::withCount([
            'galeri',
            'galeri as jumlah_foto' => function ($query) {
                $query->whereIn('tipe', ['foto', 'photo']);
            },
            'galeri as jumlah_video' => function ($query) {
                $query->where('tipe', 'video');
            }
        ])->where(function($query) {
                $query->where(function($q) {
                    $q->where('status_admin', 'approved')
                      ->where('status_pimpinan', 'approved');
                })->orWhere('created_by', auth()->check() ? auth()->user()->id_user : null);
            })
            ->orderBy('created_at', 'desc')->get();
        
        $totalFoto = Galeri::whereIn('tipe', ['foto', 'photo'])->where('status_admin', 'approved')->where('status_pimpinan', 'approved')->count();
        $totalVideo = Galeri::where('tipe', 'video')->where('status_admin', 'approved')->where('status_pimpinan', 'approved')->count();
        $totalAlbum = Album::where('status_admin', 'approved')->where('status_pimpinan', 'approved')->count();
        $kategoriList = ['Event', 'Reuni', 'Kegiatan Pesantren', 'Foto Angkatan'];
        $tahunList = Album::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('alumni.galeri', compact(
            'albums',
            'totalFoto',
            'totalVideo',
            'totalAlbum',
            'kategoriList',
            'tahunList'
        ));
    }

    public function upload(Request $request)
    {
        // Validasi berbeda untuk foto dan video
        $rules = [
            'album_id' => 'required|exists:album,id',
            'tipe' => 'required|in:foto,video',
            'deskripsi' => 'nullable|string',
        ];

        // Tambahkan validasi file sesuai tipe
        if ($request->tipe === 'video') {
            $rules['file'] = 'required|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:51200'; // Max 50MB untuk video
        } else {
            $rules['file'] = 'required|file|mimes:jpeg,png,jpg,gif,webp|max:10240'; // Max 10MB untuk foto
        }

        $request->validate($rules);

        // Simpan file ke storage
        $path = $request->file('file')->store('galeri/' . $request->album_id, 'public');

        // Simpan ke database
        Galeri::create([
            'album_id' => $request->album_id,
            'file_path' => $path,
            'tipe' => $request->tipe,
            'deskripsi' => $request->deskripsi,
            'uploaded_by' => auth()->check() ? auth()->user()->id_user : null,
        ]);

        return back()->with('success', 'Berhasil, menunggu persetujuan dari admin dan pimpinan baru akan tampil.');
    }

    public function show($id)
    {
        $album = Album::with(['galeri' => function($query) {
            $query->where(function($q) {
                $q->where('status_admin', 'approved')->where('status_pimpinan', 'approved');
            })->orWhere('uploaded_by', auth()->check() ? auth()->user()->id_user : null);
        }])->where('id', $id)->where(function($query) {
            $query->where(function($q) {
                $q->where('status_admin', 'approved')->where('status_pimpinan', 'approved');
            })->orWhere('created_by', auth()->check() ? auth()->user()->id_user : null);
        })->firstOrFail();

        return view('alumni.galeri-show', compact('album'));
    }

    public function storeAlbum(Request $request)
    {
        $request->validate([
            'nama_album' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tahun' => 'required|string|max:10',
            'kategori' => 'nullable|string|max:100',
            'cover' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $coverPath = $request->file('cover')->store('uploads/album_cover', 'public');

        Album::create([
            'nama_album' => $request->nama_album,
            'deskripsi' => $request->deskripsi,
            'tahun' => $request->tahun,
            'kategori' => $request->kategori,
            'cover' => $coverPath,
            'created_by' => auth()->check() ? auth()->user()->id_user : null,
        ]);

        return back()->with('success', 'Berhasil, menunggu persetujuan dari admin dan pimpinan baru akan tampil.');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        
        // Pengecekan kepemilikan
        if ($galeri->uploaded_by !== auth()->user()->id_user) {
            return back()->with('error', 'Anda tidak memiliki hak untuk menghapus file ini.');
        }

        Storage::disk('public')->delete(str_replace('storage/', '', $galeri->file_path));
        $galeri->delete();

        return back()->with('success', 'File berhasil dihapus.');
    }

    public function destroyAlbum($id)
    {
        $album = Album::findOrFail($id);
        
        // Pengecekan kepemilikan
        if ($album->created_by !== auth()->user()->id_user) {
            return redirect()->route('galeri.index')->with('error', 'Anda tidak memiliki hak untuk menghapus album ini.');
        }
        
        // Hapus semua file galeri yang ada di album
        foreach ($album->galeri as $item) {
            Storage::disk('public')->delete(str_replace('storage/', '', $item->file_path));
        }
        
        // Hapus cover album
        if ($album->cover) {
            Storage::disk('public')->delete(str_replace('storage/', '', $album->cover));
        }
        
        // Hapus semua galeri di album
        $album->galeri()->delete();
        
        // Hapus album
        $album->delete();

        return redirect()->route('galeri.index')->with('success', 'Album berhasil dihapus!');
    }

}
