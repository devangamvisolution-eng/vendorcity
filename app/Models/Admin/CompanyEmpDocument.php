<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class CompanyEmpDocument extends Model
{
    use HasFactory;

    protected $table = 'company_emp_documents';

    public $timestamps = false;

    protected $fillable = [
        'eid',
        'title',
        'document',
    ];

    public function companyEmployees(): BelongsTo
    {
        return $this->belongsTo(CompanyEmployee::class,'eid','id');
    }
}
