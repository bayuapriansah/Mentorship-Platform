<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamChat extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    function admin() {
        return $this->belongsTo(User::class, "sender_id");
    }
    function mentor() {
        return $this->belongsTo(Mentor::class, "sender_id");
    }
    function student() {
        return $this->belongsTo(Student::class, "sender_id");
    }
}
