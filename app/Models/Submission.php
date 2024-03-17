<?php

namespace App\Models;

use App\Models\Grade;
use App\Models\SectionSubsection;
use App\Models\ReadNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'student_id',
        'project_id',
        'is_complete',
        'flag_checkpoint',
        'file',
        'dataset',
        'release_date',
        'dueDate',
        'taskNumber',
        'type',
        'mentorshipType',
    ];

    public function projectSection()
    {
        return $this->belongsTo(ProjectSection::class,'section_id','id');
    }

    public function grade()
    {
        return $this->hasOne(Grade::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function read_notification()
    {
        return $this->belongsTo(ReadNotification::class);
    }
}
