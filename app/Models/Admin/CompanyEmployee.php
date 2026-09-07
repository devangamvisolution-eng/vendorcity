<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Enums\EmployeeType;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CompanyEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee',
        'name',
        'expiry_date_eid',
    ];

    protected function casts(): array
    {
        return [
            'employees' => EmployeeType::class,
        ];
    }

    public function companyEmpDocuments(): HasMany
    {
        return $this->hasMany(CompanyEmpDocument::class, 'eid', 'id');
    }

    protected function employeeTypeLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => EmployeeType::from($this->employee)->label()
        );
    }
}
