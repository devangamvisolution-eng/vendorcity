<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubserviceMoreService extends Model
{
    use HasFactory;
    
    protected $table = 'subservice_more_services';
    
    protected $fillable = [
        'subservice_id',
        'city',
        'more_subservice_id'
    ];
}
