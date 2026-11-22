<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'is_negotiable',
        'condition',
        'condition_grade',
        'size_tier',
        'status',
        'campus_zone',
        'is_flagged',
        'takedown_reason',
        'image_url',
        'pickup_location',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_negotiable' => 'boolean',
        ];
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function priceOffers(): HasMany
    {
        return $this->hasMany(PriceOffer::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }


    public function getFacultyAttribute(): string
    {
        if ($this->seller) {
            return $this->seller->faculty;
        }
        return ($this->campus_zone === 'Cilegon') ? 'Fakultas Teknik' : 'Civitas Untirta';
    }

    public function getFacultyCodeAttribute(): string
    {
        if ($this->seller) {
            return $this->seller->faculty_code;
        }
        return ($this->campus_zone === 'Cilegon') ? 'FT' : 'Untirta';
    }
}
