<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reseller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reseller_code',
        'company_name',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'commission_rate',
        'status',
        'balance',
        'total_earnings',
        'total_transactions',
        'referral_code',
        'referred_by',
        'approved_at',
        'approved_by'
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'balance' => 'decimal:2',
        'total_earnings' => 'decimal:2',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Reseller Statuses
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_REJECTED = 'rejected';

    // Commission Tiers
    const TIER_BRONZE = 'bronze'; // 5% commission
    const TIER_SILVER = 'silver'; // 7% commission
    const TIER_GOLD = 'gold';     // 10% commission
    const TIER_PLATINUM = 'platinum'; // 12% commission

    /**
     * Get the user that owns the reseller account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who approved this reseller.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the reseller who referred this reseller.
     */
    public function referredBy(): BelongsTo
    {
        return $this->belongsTo(Reseller::class, 'referred_by');
    }

    /**
     * Get resellers referred by this reseller.
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(Reseller::class, 'referred_by');
    }

    /**
     * Get transactions made by this reseller.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'reseller_id');
    }

    /**
     * Get withdrawal requests by this reseller.
     */
    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class, 'reseller_id');
    }

    /**
     * Generate unique reseller code.
     */
    public static function generateResellerCode(): string
    {
        do {
            $code = 'RS' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('reseller_code', $code)->exists());

        return $code;
    }

    /**
     * Generate unique referral code.
     */
    public static function generateReferralCode(): string
    {
        do {
            $code = 'REF' . strtoupper(substr(md5(uniqid()), 0, 6));
        } while (self::where('referral_code', $code)->exists());

        return $code;
    }

    /**
     * Check if reseller is active.
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if reseller is pending approval.
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if reseller is suspended.
     */
    public function isSuspended(): bool
    {
        return $this->status === self::STATUS_SUSPENDED;
    }

    /**
     * Get commission amount for a transaction.
     */
    public function calculateCommission(float $amount): float
    {
        return ($amount * $this->commission_rate) / 100;
    }

    /**
     * Add commission to balance.
     */
    public function addCommission(float $amount): void
    {
        $this->increment('balance', $amount);
        $this->increment('total_earnings', $amount);
        $this->increment('total_transactions');
    }

    /**
     * Deduct from balance (for withdrawals).
     */
    public function deductBalance(float $amount): bool
    {
        if ($this->balance >= $amount) {
            $this->decrement('balance', $amount);
            return true;
        }
        return false;
    }

    /**
     * Get tier based on total earnings.
     */
    public function getTier(): string
    {
        $earnings = $this->total_earnings;

        if ($earnings >= 10000000) { // 10M
            return self::TIER_PLATINUM;
        } elseif ($earnings >= 5000000) { // 5M
            return self::TIER_GOLD;
        } elseif ($earnings >= 1000000) { // 1M
            return self::TIER_SILVER;
        } else {
            return self::TIER_BRONZE;
        }
    }

    /**
     * Get commission rate based on tier.
     */
    public function getCommissionRate(): float
    {
        return match($this->getTier()) {
            self::TIER_PLATINUM => 12.0,
            self::TIER_GOLD => 10.0,
            self::TIER_SILVER => 7.0,
            default => 5.0
        };
    }

    /**
     * Get formatted balance.
     */
    public function getFormattedBalanceAttribute(): string
    {
        return 'Rp ' . number_format($this->balance, 0, ',', '.');
    }

    /**
     * Get formatted total earnings.
     */
    public function getFormattedTotalEarningsAttribute(): string
    {
        return 'Rp ' . number_format($this->total_earnings, 0, ',', '.');
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            self::STATUS_ACTIVE => 'bg-green-100 text-green-800',
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_SUSPENDED => 'bg-red-100 text-red-800',
            self::STATUS_REJECTED => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Scope for active resellers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope for pending resellers.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Get reseller statistics.
     */
    public static function getStatistics()
    {
        return [
            'total_resellers' => self::count(),
            'active_resellers' => self::active()->count(),
            'pending_resellers' => self::pending()->count(),
            'total_commission_paid' => self::sum('total_earnings'),
            'total_balance' => self::sum('balance'),
        ];
    }
} 