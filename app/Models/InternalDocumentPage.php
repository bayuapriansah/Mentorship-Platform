<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InternalDocumentPage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function internalDocumentGroupSection()
    {
        return $this->belongsTo(InternalDocumentGroupSection::class);
    }
}
