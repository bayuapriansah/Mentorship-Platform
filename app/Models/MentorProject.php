<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorProject extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }
}
