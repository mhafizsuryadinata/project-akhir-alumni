<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'date',
        'time',
        'location',
        'description',
        'image',
        'status',
        'status_admin',
        'status_pimpinan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}
