<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';
    protected $fillable = ['album_id', 'file', 'file_path', 'tipe', 'deskripsi', 'uploaded_by', 'status_admin', 'status_pimpinan'];

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id_user');
    }
}
