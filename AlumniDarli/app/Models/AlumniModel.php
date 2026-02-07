<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniModel extends Model
{
    use HasFactory;
    protected $table = 'alumni';
    protected $primaryKey = 'id_alumni';
    protected $fillable = ['nama', 'angkatan', 'alamat', 'no_hp','is_complete', 'foto'];
}
