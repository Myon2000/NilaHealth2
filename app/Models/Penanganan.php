<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penanganan extends Model
{
    protected $fillable = ['diagnosis_id', 'deskripsi'];

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }
}

