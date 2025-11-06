<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'employee_id',
        'current_address',
        'permanent_address'
    ];

    // Address belongs to one employee
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
