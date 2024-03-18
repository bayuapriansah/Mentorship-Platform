<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyAdmin extends Model
{
    protected $fillable = ['id_admin', 'notify_admin_data'];

    protected $casts = [
        'notify_admin_data' => 'array',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id');
    }
}
