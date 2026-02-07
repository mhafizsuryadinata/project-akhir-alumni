<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $fillable = ['nomor_nia', 'username','nama','alamat','no_hp','pekerjaan','email','lokasi','bio','foto','profile','active', 'role','is_complete', 'settings', 'privacy', 'instagram', 'linkedin', 'pendidikan_lanjutan', 'tahun_masuk', 'tahun_tamat'];

    protected $casts = [
        'settings' => 'array',
        'privacy' => 'array',
    ];

    public function getAuthIdentifierName() 
    {
        return 'username';
    }


    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_user', 'user_id', 'event_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}
