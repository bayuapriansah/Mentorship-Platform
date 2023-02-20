<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'company_id', 'is_confirm'];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
