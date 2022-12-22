<?php

namespace App\Models;

use App\Models\Project;
use App\Models\Student;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Batch extends Model
{
    use HasFactory;
    
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    protected $fillable = ['batch_number', 'start_date', 'end_date', 'company_id'];
}
