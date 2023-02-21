<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;
    public function project()
    {
        return $this->hasMany(Project::class);
    }
    
    public function mentors()
    {
        return $this->hasMany(Mentor::class);
    }
}
