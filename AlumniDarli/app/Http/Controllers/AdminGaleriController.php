<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminGaleriController extends Controller
{
    public function index()
    {
        $stats = [
            'total_album' => Album::count(),
            'total_photo' => Galeri::whereIn('tipe', ['photo', 'foto'])->count(),
            'total_video' => Galeri::where('tipe', 'video')->count(),
        ];

        $albums = Album::with(['creator'])->withCount(['galeri as total_photos' => function ($query) {
            $query->whereIn('tipe', ['photo', 'foto']);
        }, 'galeri as total_videos' => function ($query) {
            $query->where('tipe', 'video');
        }])->latest()->get();

        return view('admin.galeri.index', compact('stats', 'albums'));
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
            'status_admin' => 'approved'
        ]);

        return redirect()->back()->with('success', 'Album berhasil dibuat!');
    }

    public function show($id)
    {
        $album = Album::with(['galeri.uploader', 'creator'])->findOrFail($id);
        
        $stats = [
            'photos' => $album->galeri->whereIn('tipe', ['photo', 'foto'])->count(),
            'videos' => $album->galeri->where('tipe', 'video')->count(),
        ];

        return view('admin.galeri.show', compact('album', 'stats'));
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
            // Delete old cover
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

        // Delete all media files
        foreach ($album->galeri as $media) {
            if (Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
        }

        // Delete cover
        if ($album->cover && Storage::disk('public')->exists($album->cover)) {
            Storage::disk('public')->delete($album->cover);
        }

        $album->galeri()->delete();
        $album->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Album berhasil dihapus!');
    }

    public function uploadMedia(Request $request, $id)
    {
        $album = Album::findOrFail($id);

        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:20480', // Max 20MB
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
            'status_admin' => 'approved'
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

    public function approveAlbum($id)
    {
        $album = Album::findOrFail($id);
        $album->update(['status_admin' => 'approved']);
        return back()->with('success', 'Album disetujui Admin!');
    }

    public function rejectAlbum($id)
    {
        $album = Album::findOrFail($id);
        $album->update(['status_admin' => 'rejected']);
        return back()->with('success', 'Album ditolak Admin!');
    }

    public function approveMedia($id)
    {
        $media = Galeri::findOrFail($id);
        $media->update(['status_admin' => 'approved']);
        return back()->with('success', 'Media disetujui Admin!');
    }

    public function rejectMedia($id)
    {
        $media = Galeri::findOrFail($id);
        $media->update(['status_admin' => 'rejected']);
        return back()->with('success', 'Media ditolak Admin!');
    }
}
