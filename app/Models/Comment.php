<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'komentar';
    
    protected $fillable = [
        'artikel_id',
        'users_id',
        'isi'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'artikel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    protected $appends = ['created_time'];

    public function getCreatedTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}