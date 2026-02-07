<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongan';

    protected $fillable = [
        'judul',
        'perusahaan',
        'lokasi',
        'tipe_pekerjaan',
        'level',
        'deskripsi',
        'kualifikasi',
        'benefit',
        'gaji_min',
        'gaji_max',
        'logo_perusahaan',
        'email_kontak',
        'website',
        'tanggal_tutup',
        'status',
        'posted_by',
        'status_admin',
        'status_pimpinan',
    ];

    protected $dates = ['tanggal_tutup'];

    // Relasi dengan User (yang posting lowongan)
    public function poster()
    {
        return $this->belongsTo(User::class, 'posted_by', 'id_user');
    }

    // Relasi dengan Lamaran
    public function lamaran()
    {
        return $this->hasMany(Lamaran::class);
    }

    // Cek apakah lowongan masih aktif
    public function isActive()
    {
        return $this->status === 'Aktif' && $this->tanggal_tutup >= now();
    }

    // Scope untuk lowongan aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'Aktif')
                     ->where('tanggal_tutup', '>=', now());
    }
}
