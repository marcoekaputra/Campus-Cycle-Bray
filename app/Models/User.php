<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'nim', 'campus_name', 'campus_zone', 'role', 'is_suspended'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_suspended' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'campus_admin'], true);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isCampusAdmin(): bool
    {
        return $this->role === 'campus_admin';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function priceOffers(): HasMany
    {
        return $this->hasMany(PriceOffer::class, 'buyer_id');
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id')->latest();
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Order::class, 'seller_id')->latest();
    }

    public function buyerConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'buyer_id')->latest('last_message_at');
    }

    public function sellerConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'seller_id')->latest('last_message_at');
    }

    public function allConversations()
    {
        return Conversation::where('buyer_id', $this->id)
            ->orWhere('seller_id', $this->id)
            ->latest('last_message_at');
    }

    public function unreadChatCount(): int
    {
        return ChatMessage::whereHas('conversation', function ($query) {
            $query->where('buyer_id', $this->id)
                  ->orWhere('seller_id', $this->id);
        })
        ->where('sender_id', '!=', $this->id)
        ->where('is_read', false)
        ->count();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function receivedReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'seller_id');
    }

    public function disputes(): HasMany
    {
        return $this->hasMany(Dispute::class, 'complainant_id');
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class, 'user_id');
    }


    public function getFacultyAttribute(): string
    {
        $prefix = substr($this->nim ?? '', 0, 3);
        return match ($prefix) {
            '333' => 'Fakultas Teknik',
            '222' => 'Fakultas Ekonomi & Bisnis',
            '111' => 'Fakultas Hukum',
            '666' => 'FISIP',
            '444' => 'Fakultas Pertanian',
            '555' => 'Fakultas Kedokteran',
            '777', '228' => 'FKIP',
            '888' => 'Pascasarjana',
            default => ($this->campus_zone === 'Cilegon' ? 'Fakultas Teknik' : 'Civitas Untirta'),
        };
    }

    public function getFacultyCodeAttribute(): string
    {
        $prefix = substr($this->nim ?? '', 0, 3);
        return match ($prefix) {
            '333' => 'FT',
            '222' => 'FEB',
            '111' => 'FH',
            '666' => 'FISIP',
            '444' => 'FP',
            '555' => 'FK',
            '777', '228' => 'FKIP',
            '888' => 'SPs',
            default => ($this->campus_zone === 'Cilegon' ? 'FT' : 'Untirta'),
        };
    }
}
