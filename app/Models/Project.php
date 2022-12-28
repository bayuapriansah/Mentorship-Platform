<?php

namespace App\Models;

use App\Models\Batch;
use App\Models\Company;
use App\Models\Student;
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

    public function mentors()
    {
        return $this->belongsToMany(Mentor::class);
    }
}
