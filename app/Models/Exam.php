<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exam extends Model
{
    protected $fillable = [
        'subject_id',
        'created_by',
        'title',
        'description',
        'time_limit_minutes',
        'starts_at',
        'ends_at',
        'is_published',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    // relationships
    // an exam belongs to a subject and a creator (user)
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    // the creator of the exam is a user (lecturer)
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
