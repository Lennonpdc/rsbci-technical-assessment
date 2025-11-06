<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{

    use HasFactory;

    protected $fillable = [
        'department_id',
        'first_name',
        'last_name',
        'email',
        'date_hired'
    ];

    // Employee belongs to one department
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    // Employee can have many addresses
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    // Employee can have many projects
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'employee_projects')
            ->withPivot(['role', 'start_date', 'end_date'])
            ->withTimestamps();
    }

    //
    public function getDepartmentName(): string
    {
        return $this->department->name;
    }
}
