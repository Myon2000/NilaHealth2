<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Models\Notification;

class Jadwal extends Model
{
use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'users_id',
        'tanggal',           // <— tambahkan
        'waktu',
        'keterangan',
        'recurrence_type',
        'recurrence_days',
        'remind_before',
    ];

    protected $casts = [
        'tanggal'         => 'date',          // <— cast jadi date
        'waktu'           => 'datetime:H:i',
        'recurrence_days' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}