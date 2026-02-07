<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontakUstadz extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'bidang',
        'no_hp',
        'email',
        'foto'
    ];
}
