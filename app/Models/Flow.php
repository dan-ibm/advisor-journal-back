<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flow extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'advisor_id',
    ];

    public function advisor(): BelongsTo
    {
        return $this->belongsTo(Advisor::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
}
