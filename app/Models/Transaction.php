<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'user_id',
        'mechanic_id',
        'mechanic_ids',
        'subtotal',
        'discount',
        'tax',
        'total',
        'payment_method',
        'cash_received',
        'change',
        'status',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'cash_received' => 'decimal:2',
        'change' => 'decimal:2',
        'mechanic_ids' => 'array',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mechanic(): BelongsTo
    {
        return $this->belongsTo(Mechanic::class);
    }

    public function getMechanicsAttribute()
    {
        if (empty($this->mechanic_ids)) {
            return collect();
        }
        return Mechanic::whereIn('id', $this->mechanic_ids)->get();
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function getProductItemsAttribute()
    {
        return $this->items->where('item_type', 'product');
    }

    public function getServiceItemsAttribute()
    {
        return $this->items->where('item_type', 'service');
    }

    public static function generateInvoiceNumber()
    {
        $date = now()->format('Ymd');
        $random = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        return "INV-{$date}-{$random}";
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now()->toDateString());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
