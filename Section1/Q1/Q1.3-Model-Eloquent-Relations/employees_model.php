<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'department_id',
        'first_name',
        'last_name',
        'email',
        'hire_date'
    ];

    // Employee belongs to one department
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    // Employee has many addresses
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
