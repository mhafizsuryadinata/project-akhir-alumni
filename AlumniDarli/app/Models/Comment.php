<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $fillable = [
        'user_id',
        'target_user_id',
        'content',
        'rating',
        'parent_id',
        'admin_status',
        'mudir_status',
        'admin_reply',
        'admin_reply_date',
        'mudir_reply',
        'mudir_reply_date'
    ];

    // Relasi: user yang memberi komentar
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    // Relasi: user yang dikomentari
    public function target()
    {
        return $this->belongsTo(User::class, 'target_user_id', 'id_user');
    }

    // Relasi: balasan dari komentar
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    // Relasi: komentar induk (jika ini balasan)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'id');
    }


}
