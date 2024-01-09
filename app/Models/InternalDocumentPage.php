<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalDocumentPage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function internalDocumentGroupSection()
    {
        return $this->belongsTo(InternalDocumentGroupSection::class);
    }
}
