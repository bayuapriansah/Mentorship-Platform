<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Project;
use App\Models\Feedback;


class Student extends Authenticatable
{
    use HasFactory;

    protected $guard = 'student';

    // protected $fillable = ['name', 'email', 'password', 'institution_id'];
    protected $guarded = [];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class,'id','student_id');
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }
    public function staff()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function enrolled_projects()
    {
        return $this->hasMany(EnrolledProject::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }

    public function loginLogs()
    {
        return $this->hasMany(LoginLog::class, 'student_id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getMentorshipTrack()
    {
        switch ($this->mentorship_type) {
            case 'skills_track':
                return 'Skills';
                break;

            case 'entrepreneur_track':
                return 'Entrepreneur';
                break;

            default:
                return '-';
                break;
        }
    }
}
