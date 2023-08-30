<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'feedback'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}