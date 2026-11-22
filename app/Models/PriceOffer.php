<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PriceOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'buyer_id',
        'offered_price',
        'message',
        'status',
        'seller_note',
    ];

    protected function casts(): array
    {
        return [
            'offered_price' => 'decimal:2',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
