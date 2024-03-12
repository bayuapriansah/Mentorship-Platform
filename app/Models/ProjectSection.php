<?php

namespace App\Models;

use App\Models\Project;
use App\Models\SectionSubsection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectSection extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['project_id', 'section', 'title', 'description', 'dataset_label', 'dataset', 'duration', 'assigned_to', 'due_date', 'file_type'];
    protected $casts = [
        'dataset_label' => 'array', // Add this
        'dataset' => 'array', // Add this
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sectionSubsections()
    {
        return $this->hasMany(SectionSubsection::class);
    }

    public function submission()
    {
        return $this->hasOne(Submission::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'section_id', 'id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class,'id','project_section_id');
    }
}
