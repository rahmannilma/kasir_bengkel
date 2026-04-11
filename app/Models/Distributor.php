<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Distributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'company',
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(DistributorNote::class);
    }
}
