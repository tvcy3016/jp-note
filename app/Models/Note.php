<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'user_id',
        'note_type',
        'title',
        'content',

        // vocabulary
        'reading',
        'meaning',

        // grammar
        'usage',
        'example',

        // mistake
        'question',
        'answer',
        'explanation',
        'difficulty',
    ];

}

