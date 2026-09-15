<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'website',
        'mobile',
        'address',
        'gmap',
    ];


    public function companyProfileDocuments(): HasMany
    {
        return $this->hasMany(CompanyProfileDocument::class);
    }
}
