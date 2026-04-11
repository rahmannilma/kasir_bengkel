<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'vehicle_plate',
        'vehicle_brand',
        'vehicle_type',
        'notes',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getTotalSpendingAttribute()
    {
        return $this->transactions()->sum('total');
    }

    public function getTransactionCountAttribute()
    {
        return $this->transactions()->count();
    }
}
