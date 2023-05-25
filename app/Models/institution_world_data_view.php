<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class institution_world_data_view extends Model
{
    use HasFactory;
    public function project()
    {
        return $this->hasMany(Project::class);
    }
    
    public function mentors()
    {
        return $this->hasMany(Mentor::class, 'institution_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'institution_id', 'id');
    }
}
