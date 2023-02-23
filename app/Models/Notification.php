<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['project_id'];
    public function project()
    {
    return $this->belongsTo(Project::class);
    }
}
