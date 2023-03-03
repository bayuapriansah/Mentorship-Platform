<?php

namespace App\Models;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadNotification extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'notifications_id', 'is_read'];
    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function notification()
    {
    return $this->hasOne(Notification::class,'notifications_id','id');
    }
}
