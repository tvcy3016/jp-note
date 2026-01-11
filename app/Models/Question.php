<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'user_id',
        'note_id',
        'question_type',
        'question_text',
        'answer_text',
        'choices',
        'explanation',
        'review_level',
    ];

    protected $casts = [
        'choices' => 'array',
    ];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
