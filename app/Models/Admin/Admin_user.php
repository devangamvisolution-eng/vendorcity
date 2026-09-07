<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_user extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_id',
        'name',
        'user_name',
        'email',
        'password',
        'mobile',
        // other fillable properties
    ];
}