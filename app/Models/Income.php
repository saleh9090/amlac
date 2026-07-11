<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'amount',
        'income_category_id',
        'note',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        // Record creation timestamp should reflect the income's own
        // date, not the moment it was entered into the system.
        static::creating(function (Income $income): void {
            if ($income->date) {
                $income->created_at = $income->date;
            }
        });
    }

    public function incomeCategory(): BelongsTo
    {
        return $this->belongsTo(IncomeCategory::class);
    }
}
