<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $table = 'album';
    protected $fillable = ['nama_album', 'deskripsi', 'tahun', 'kategori', 'cover', 'created_by', 'status_admin', 'status_pimpinan'];

    public function galeri()
    {
        return $this->hasMany(Galeri::class, 'album_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }
}
