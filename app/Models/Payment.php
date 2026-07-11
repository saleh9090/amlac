<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'payment_for_month',
        'payment_for_year',
        'paid_amount',
        'payment_date',
        'status',
        'note',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'paid_amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (Payment $payment): void {
            $due = (float) ($payment->unit?->contract?->rent_amount ?? 0);
            $paid = (float) $payment->paid_amount;

            if ($paid <= 0) {
                $payment->status = 'unpaid';
            } elseif ($paid >= $due) {
                $payment->status = 'paid';
            } else {
                $payment->status = 'partial';
            }
        });
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * The rent due is the unit's contract rent amount — it isn't stored
     * on the payment itself.
     */
    public function getDueAmountAttribute(): float
    {
        return (float) ($this->unit?->contract?->rent_amount ?? 0);
    }

    public function getOutstandingAmountAttribute(): float
    {
        return max(0, $this->due_amount - (float) $this->paid_amount);
    }

    public static function monthName(int $month): string
    {
        return [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
        ][$month] ?? (string) $month;
    }
}
