<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_number',
        'tenant_id',
        'unit_id',
        'start_date',
        'duration_months',
        'end_date',
        'rent_amount',
        'payment_frequency',
        'payment_method',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'rent_amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (Contract $contract): void {
            if ($contract->start_date && $contract->duration_months) {
                $contract->end_date = Carbon::parse($contract->start_date)
                    ->addMonthsNoOverflow((int) $contract->duration_months)
                    ->subDay();
            }

            if ($contract->end_date) {
                $contract->status = Carbon::parse($contract->end_date)->isPast() ? 'inactive' : 'active';
            }
        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
