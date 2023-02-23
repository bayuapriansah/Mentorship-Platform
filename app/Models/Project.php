<?php

namespace App\Models;

use App\Models\Batch;
use App\Models\Company;
use App\Models\Student;
use App\Models\ProjectSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'problem', 'image', 'batch_id', 'student_id', 'company_id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function projectSections()
    {
        return $this->hasMany(ProjectSection::class);
    }

    public function mentors()
    {
        return $this->belongsToMany(Mentor::class);
    }

    public function enrolled_project()
    {
        return $this->hasMany(EnrolledProject::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class,'id','project_id');
    }
}
