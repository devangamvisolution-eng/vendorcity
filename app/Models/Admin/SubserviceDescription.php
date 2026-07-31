<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubserviceDescription extends Model
{
    use HasFactory;
    
    protected $table = 'subservice_descriptions';
    
    protected $fillable = [
        'subservice_id',
        'city',
        'description'
    ];
}
