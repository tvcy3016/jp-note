<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'note_id',
        'question_type',
        'question_text',
        'answer_text',
        'choices',
        'explanation',
        'review_level',
        // 新增 SRS 欄位
        'ease_factor',
        'interval_days',
        'repetitions',
        'next_review_at',
    ];

    protected $casts = [
        'choices' => 'array',
        'next_review_at' => 'datetime', // 自動轉為 Carbon 物件方便操作
    ];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}