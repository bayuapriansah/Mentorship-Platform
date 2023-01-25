<?php

namespace App\Models;

use App\Models\Project;
use App\Models\SectionSubsection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectSection extends Model
{
    use HasFactory;

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

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
