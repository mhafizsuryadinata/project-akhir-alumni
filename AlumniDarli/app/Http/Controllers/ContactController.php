<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminContactNotification;
use Auth;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validasi
        $data = $request->validate([
            'subject' => 'required',
            'message' => 'required',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        // Upload file jika ada
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('contact_attachments', 'public');
        }

        // Simpan ke database
        $saved = ContactMessage::create([
            'user_id' => Auth::user()->id_user,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'attachment' => $attachmentPath,
        ]);

        // Kirim email ke admin
        Mail::to('admin@darli.com')->send(new AdminContactNotification($saved));

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}
