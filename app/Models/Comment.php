<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function student(){
        return $this->hasOne(Student::class);
    }

    public function project(){
        return $this->hasOne(Project::class);
    }

    public function project_section(){
        return $this->hasOne(ProjectSection::class);
    }

    public function mentor(){
        return $this->hasOne(Mentor::class);
    }
}
