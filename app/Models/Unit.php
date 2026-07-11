<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'unit_number',
        'unit_type',
        'layout',
        'floor',
        'area',
        'electricity_account',
        'water_account',
        'status',
        'notes',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * A unit has exactly one contract for its whole life. Renewing or
     * changing tenant updates this same contract instead of creating
     * a new row (enforced by a unique index on contracts.unit_id).
     */
    public function contract(): HasOne
    {
        return $this->hasOne(Contract::class);
    }

    /**
     * Monthly rent payments recorded directly against this unit.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
