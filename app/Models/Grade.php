<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }
}
