<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'buyer_id',
        'seller_id',
        'product_id',
        'price_offer_id',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'delivery_method',
        'destination_zone',
        'destination_address',
        'shipping_fee',
        'buyer_app_fee',
        'seller_app_fee',
        'net_seller_amount',
        'va_bank',
        'va_number',
        'va_expired_at',
        'tracking_number',
        'meetup_location',
        'notes',
        'return_status',
        'return_method',
        'return_courier',
        'return_tracking_number',
        'return_shipping_fee',
        'return_reason',
        'return_description',
        'return_proof_image',
        'return_refund_amount',
        'return_requested_at',
        'return_seller_confirmed_at',
        'return_admin_approved_at',
        'paid_at',
        'completed_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'shipping_fee' => 'decimal:2',
            'buyer_app_fee' => 'decimal:2',
            'seller_app_fee' => 'decimal:2',
            'net_seller_amount' => 'decimal:2',
            'return_shipping_fee' => 'decimal:2',
            'return_refund_amount' => 'decimal:2',
            'va_expired_at' => 'datetime',
            'return_requested_at' => 'datetime',
            'return_seller_confirmed_at' => 'datetime',
            'return_admin_approved_at' => 'datetime',
            'paid_at' => 'datetime',
            'completed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function priceOffer(): BelongsTo
    {
        return $this->belongsTo(PriceOffer::class);
    }

    public function mutations(): HasMany
    {
        return $this->hasMany(WalletMutation::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function disputes(): HasMany
    {
        return $this->hasMany(Dispute::class);
    }

    /**
     * Cek apakah pembayaran menggunakan Virtual Account
     */
    public function isVaPayment(): bool
    {
        return in_array($this->payment_method, ['va_bca', 'va_bri', 'va_mandiri']);
    }

    /**
     * Format label Bank Virtual Account
     */
    public function formattedVaBank(): string
    {
        return match ($this->va_bank ?? $this->payment_method) {
            'bca', 'va_bca' => 'BCA Virtual Account',
            'bri', 'va_bri' => 'BRI Virtual Account (BRIVA)',
            'mandiri', 'va_mandiri' => 'Mandiri Virtual Account',
            default => 'Virtual Account',
        };
    }

    /**
     * Cek apakah pesanan memenuhi syarat komplain return (hanya untuk pengiriman / non-COD)
     */
    public function isReturnable(): bool
    {
        return $this->delivery_method === 'delivery'
            && in_array($this->status, ['shipped', 'processing', 'completed'])
            && in_array($this->return_status, ['none', null]);
    }

    /**
     * Nomor Faktur Resmi Pembelian
     */
    public function invoiceNumber(): string
    {
        return 'INV/' . ($this->created_at ? $this->created_at->format('Ymd') : date('Ymd')) . '/CC/' . $this->id;
    }
}
