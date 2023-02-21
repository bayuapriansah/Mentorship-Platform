<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkEmailInvitation extends Model
{
    use HasFactory;
    protected $fillable = ['original_name','extension','current_name'];
}
