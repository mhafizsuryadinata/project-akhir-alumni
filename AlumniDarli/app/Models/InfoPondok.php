<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoPondok extends Model
{
    use HasFactory;

    protected $table = 'info_pondok';

    protected $fillable = [
        'judul',
        'konten',
        'jenis',
        'gambar',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
