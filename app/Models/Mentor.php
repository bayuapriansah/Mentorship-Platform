<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;   

class Mentor extends Authenticatable
{
    use HasFactory;
    
    protected $guard = 'mentor';

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'mentor_projects');
    }
}
