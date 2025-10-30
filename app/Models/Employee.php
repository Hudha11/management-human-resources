<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_number',
        'name',
        'email',
        'phone',
        'gender',
        'birth_date',
        'hire_date',
        'position_id',
        'department_id',
        'address',
        'status',
        'salary',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
        'salary' => 'decimal:2',
    ];

    // relasi ke Department
    // public function department()
    // {
    //     return $this->belongsTo(Department::class);
    // }
}
