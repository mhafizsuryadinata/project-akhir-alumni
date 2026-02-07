<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Simpan komentar baru
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'target_user_id' => 'required|integer',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::user()->id_user,
            'target_user_id' => $request->target_user_id,
            'content' => $request->content,
            'rating' => $request->rating,
            'parent_id' => $request->parent_id,
            'admin_status' => 'pending',
            'mudir_status' => 'pending',
        ]);

        // Jika request dari AJAX (balasan tanpa reload)
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'content' => $comment->content,
                'rating' => $comment->rating,
                'user_nama' => Auth::user()->nama,
                'user_foto' => Auth::user()->foto 
                    ? asset('storage/' . Auth::user()->foto)
                    : asset('images/default-avatar.png'),
            ]);
        }

        // Jika bukan AJAX (komentar biasa)
        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    // Tampilkan semua komentar
    public function show($target_user_id)
    {
        $comments = Comment::where('target_user_id', $target_user_id)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->where('admin_status', 'approved')
            ->where('mudir_status', 'approved')
            ->latest()
            ->get();

        return view('alumni.dashboardAlumni', compact('comments'));
    }


    // Admin membalas komentar (ke kolom admin_reply)
    public function replyByAdmin(Request $request, $id)
    {
        $request->validate([
            'balasan' => 'required|string|max:1000'
        ]);

        $comment = Comment::findOrFail($id);
        $comment->admin_reply = $request->balasan;
        $comment->admin_reply_date = now();
        $comment->save();

        return back()->with('success', 'Balasan admin berhasil dikirim!');
    }

    // Admin membalas komentar (balasan masuk ke kolom admin_reply)
    public function balas(Request $request, $id)
    {
        $request->validate([
            'balasan' => 'required|string|max:1000',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->admin_reply = $request->balasan;
        $comment->admin_reply_date = now();
        $comment->save();

        return back()->with('success', 'Balasan admin berhasil dikirim!');
    }

}