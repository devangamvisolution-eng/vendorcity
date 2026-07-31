<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubserviceWhatElseService extends Model
{
    use HasFactory;
    
    protected $table = 'subservice_what_else_services';
    
    protected $fillable = [
        'subservice_id',
        'city',
        'what_else_subservice_id'
    ];
}
