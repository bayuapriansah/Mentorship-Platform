<?php

namespace App\Models;

use App\Models\SectionSubsection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory;

    public function sectionSubsection()
    {
        return $this->belongsTo(SectionSubsection::class);
    }
}
