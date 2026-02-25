<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    protected $fillable = [
        'classroom_id',
        'name',
        'description',
    ];

    // relationships
    // many subjects belong to one classroom
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }
}
