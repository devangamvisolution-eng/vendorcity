<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralEnquiry extends Model
{
    use HasFactory;

    protected $table = 'general_enquiries';

    protected $fillable = [
        'customer_id',
        'service_id',
        'subservice_id',
        'source_lead_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'country_code',
        'created_by',
        'salesperson_id',
        'status'
    ];
}
