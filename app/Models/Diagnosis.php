<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $fillable = ['user_id', 'hasil_diagnosis'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penanganan()
    {
        return $this->hasOne(Penanganan::class);
    }
}


