<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    protected $fillable = ['name', 'code'];

    // relationships
    // one classroom has many students
    public function students(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // one classroom has many subjects
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
