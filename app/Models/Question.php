<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'exam_id',
        'question_text',
        'type',
        'marks',
    ];

    // relationships
    // a question belongs to an exam
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    // a question can have many options (example: MCQ questions)
    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }
}
