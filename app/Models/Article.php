<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Article extends Model
{
    use HasFactory;

    protected $table = 'artikel';
    
    protected $fillable = [
        'users_id',
        'judul',
        'isi',
        'tag'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'artikel_id');
    }
}