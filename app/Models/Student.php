<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;   


class Student extends Authenticatable
{
    use HasFactory;

    protected $guard = 'student';

    protected $fillable = ['name', 'email', 'password'];
    
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'id', 'institution_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
