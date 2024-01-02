<?php

namespace App\Models;

use App\Models\Institution;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mentor extends Authenticatable
{
    use HasFactory;

    protected $guard = 'mentor';
    protected $fillable = ['email', 'institution_id', 'is_confirm'];
// change to institution hasMany
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'mentor_projects');
    }

    public function grade()
    {
        return $this->belongsToMany(Grade::class,);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function mentorStudents()
    {
        return $this->hasMany(Student::class, 'mentor_id', 'id');
    }

    public function staffStudents()
    {
        return $this->hasMany(Student::class, 'staff_id', 'id');
    }
}
