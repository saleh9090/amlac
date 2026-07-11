<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_type',
        'name',
        'id_cr',
        'phone',
        'email',
        'address',
        'notes',
    ];

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
}
