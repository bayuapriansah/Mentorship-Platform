<?php

namespace App\Models;

use App\Models\Mentor;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;   

class Company extends Authenticatable
{
    use HasFactory;
    protected $guard = 'company';


    protected $fillable = ['name', 'email', 'password'];
    
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

}
