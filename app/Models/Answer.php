<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'exam_attempt_id',
        'question_id',
        'selected_option_id',
        'text_answer',
        'awarded_marks',
    ];

    public function attempt()
    {
        return $this->belongsTo(ExamAttempt::class, 'exam_attempt_id');
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function selectedOption()
    {
        return $this->belongsTo(QuestionOption::class, 'selected_option_id');
    }
}
