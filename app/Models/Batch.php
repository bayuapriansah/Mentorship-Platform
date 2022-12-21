<?php

namespace App\Models;

use App\Models\Project;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Batch extends Model
{
    use HasFactory;
    
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function companies()
    {
        return $this->hasMany(Company::class, 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'id');
    }

    protected $fillable = ['student_id', 'company_id'];


}
