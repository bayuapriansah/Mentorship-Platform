<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InternalDocumentGroupSection extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function internalDocumentPages()
    {
        return $this->hasMany(InternalDocumentPage::class);
    }
}
