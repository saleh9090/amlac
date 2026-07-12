<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'name',
        'file_path',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }
}
