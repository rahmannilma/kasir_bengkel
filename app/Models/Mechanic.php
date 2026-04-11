<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mechanic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'specialization',
        'commission_rate',
        'is_active',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(MechanicSalary::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'mechanic_id');
    }

    public function getTotalEarningsAttribute()
    {
        return $this->salaries()->where('status', 'paid')->sum('commission_amount');
    }

    public function getPendingSalaryAttribute()
    {
        return $this->salaries()->where('status', 'pending')->sum('commission_amount');
    }

    public function getTotalServicesAttribute()
    {
        return $this->salaries()->count();
    }
}
