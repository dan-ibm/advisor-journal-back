<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Advisor extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function flow(): HasOne
    {
        return $this->hasOne(Flow::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
}
