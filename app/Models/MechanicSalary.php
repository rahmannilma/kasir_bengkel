<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MechanicSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'mechanic_id',
        'transaction_id',
        'service_amount',
        'commission_rate',
        'commission_amount',
        'period_start',
        'period_end',
        'status',
    ];

    protected $casts = [
        'service_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'period_start' => 'date',
        'period_end' => 'date',
    ];

    public function mechanic(): BelongsTo
    {
        return $this->belongsTo(Mechanic::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
