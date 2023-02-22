<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function project_section(){
        return $this->belongsTo(ProjectSection::class);
    }

    public function mentor(){
        return $this->belongsTo(Mentor::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
