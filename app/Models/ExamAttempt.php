<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
