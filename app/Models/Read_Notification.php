<?php

namespace App\Models;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Read_Notification extends Model
{
    use HasFactory;
    
    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function notification()
    {
    return $this->belongsTo(Notification::class);
    }
}
