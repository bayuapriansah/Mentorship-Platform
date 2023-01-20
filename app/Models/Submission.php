<?php

namespace App\Models;

use App\Models\Grade;
use App\Models\SectionSubsection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory;

    public function projectSection()
    {
        return $this->belongsTo(ProjectSection::class);
    }

    public function grade()
    {
        return $this->hasOne(Grade::class);
    }
}
