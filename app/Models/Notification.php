<?php

namespace App\Models;

use App\Models\Project;
use App\Models\Read_Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','status'];

    public function project()
    {
    return $this->belongsTo(Project::class);
    }

    public function read_notification()
    {
    return $this->belongsTo(Read_Notification::class);
    }
}
