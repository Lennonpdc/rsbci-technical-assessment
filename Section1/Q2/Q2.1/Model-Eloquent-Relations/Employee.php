<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
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

    // Added this relationship
    // Employee can have many projects
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)
            ->withPivot(['role', 'start_date'])  // pivot table
            ->withTimestamps();
    }
}
