<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'order_id',
        'transaction_code',
        'player_id',
        'player_name',
        'amount',
        'payment_method',
        'payment_status',
        'transaction_status',
        'user_id_game',
        'server_id',
        'notes',
        'digiflazz_ref_id',
        'payment_gateway_ref',
        'commission_amount',
        'reseller_id',
        'ip_address',
        'user_agent',
        'metadata'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Transaction Statuses
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REFUNDED = 'refunded';

    // Payment Statuses
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_EXPIRED = 'expired';
    const PAYMENT_FAILED = 'failed';

    /**
     * Get the user that owns the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the game associated with the transaction.
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'game_id', 'product_id');
    }

    /**
     * Get the reseller associated with the transaction.
     */
    public function reseller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reseller_id');
    }

    /**
     * Get the product associated with the transaction.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'product_id');
    }

    /**
     * Generate unique order ID.
     */
    public static function generateOrderId(): string
    {
        $prefix = 'TUHU';
        $timestamp = now()->format('YmdHis');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        
        return $prefix . $timestamp . $random;
    }

    /**
     * Check if transaction is successful.
     */
    public function isSuccessful(): bool
    {
        return $this->transaction_status === self::STATUS_SUCCESS;
    }

    /**
     * Check if transaction is pending.
     */
    public function isPending(): bool
    {
        return $this->transaction_status === self::STATUS_PENDING;
    }

    /**
     * Check if payment is completed.
     */
    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->transaction_status) {
            self::STATUS_SUCCESS => 'bg-green-100 text-green-800',
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_PROCESSING => 'bg-blue-100 text-blue-800',
            self::STATUS_FAILED => 'bg-red-100 text-red-800',
            self::STATUS_CANCELLED => 'bg-gray-100 text-gray-800',
            self::STATUS_REFUNDED => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Scope for successful transactions.
     */
    public function scopeSuccessful($query)
    {
        return $query->where('transaction_status', self::STATUS_SUCCESS);
    }

    /**
     * Scope for pending transactions.
     */
    public function scopePending($query)
    {
        return $query->where('transaction_status', self::STATUS_PENDING);
    }

    /**
     * Scope for today's transactions.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope for this month's transactions.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    /**
     * Get total revenue for a period.
     */
    public static function getRevenue($startDate = null, $endDate = null)
    {
        $query = self::successful();
        
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        return $query->sum('amount');
    }

    /**
     * Get transaction statistics.
     */
    public static function getStatistics()
    {
        return [
            'total_transactions' => self::count(),
            'successful_transactions' => self::successful()->count(),
            'pending_transactions' => self::pending()->count(),
            'total_revenue' => self::successful()->sum('amount'),
            'today_revenue' => self::successful()->today()->sum('amount'),
            'this_month_revenue' => self::successful()->thisMonth()->sum('amount'),
        ];
    }
} 