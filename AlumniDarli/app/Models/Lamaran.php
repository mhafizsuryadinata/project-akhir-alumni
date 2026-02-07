<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = 'lamaran';

    protected $fillable = [
        'lowongan_id',
        'user_id',
        'cv_path',
        'cover_letter',
        'status',
        'status_admin',
        'status_pimpinan',
    ];

    /**
     * Resoluasi status lamaran berdasarkan prioritas:
     * 1. Pimpinan (jika sudah diproses/bukan Menunggu)
     * 2. Admin (jika Pimpinan belum proses)
     * 3. Jika keduanya Menunggu, maka status adalah Menunggu
     */
    public function getFinalStatusAttribute()
    {
        if ($this->status_pimpinan !== 'Menunggu') {
            return $this->status_pimpinan;
        }
        return $this->status_admin;
    }

    // Relasi dengan Lowongan
    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }

    // Relasi dengan User (pelamar)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
