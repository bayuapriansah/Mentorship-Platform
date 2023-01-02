<?php

namespace App\Models;

use App\Models\ProjectSection;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SectionSubsection extends Model
{
    use HasFactory;

    public function projectSection()
    {
        return $this->belongsTo(ProjectSection::class);
    }
    
    public function submission()
    {
        return $this->hasOne(Submission::class);
    }
}
