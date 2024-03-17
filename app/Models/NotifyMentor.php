<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyMentor extends Model
{
    protected $fillable = ['id_mentors', 'notify_mentors_data'];

    protected $casts = [
        'notify_mentors_data' => 'array',
    ];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'id_mentors', 'id');
    }
}
