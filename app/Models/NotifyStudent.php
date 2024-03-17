<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyStudent extends Model
{
    protected $fillable = ['id_students', 'notify_data'];

    protected $casts = [
        'notify_data' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'id_students', 'id');
    }
}
