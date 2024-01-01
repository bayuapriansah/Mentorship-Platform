<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = ['student_id', 'last_ip_login', 'last_user_agent'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
