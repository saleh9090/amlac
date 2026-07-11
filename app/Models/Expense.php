<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'expense_date',
        'expense_category_id',
        'amount',
        'description',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        // Record creation timestamp should reflect the expense's own
        // date, not the moment it was entered into the system.
        static::creating(function (Expense $expense): void {
            if ($expense->expense_date) {
                $expense->created_at = $expense->expense_date;
            }
        });
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function expenseCategory(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
}
