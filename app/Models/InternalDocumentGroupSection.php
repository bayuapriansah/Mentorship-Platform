<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalDocumentGroupSection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function internalDocumentPages()
    {
        return $this->hasMany(InternalDocumentPage::class);
    }
}
