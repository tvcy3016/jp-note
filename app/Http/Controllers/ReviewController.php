<?php

namespace App\Http\Controllers;

use App\Models\Question;

class ReviewController extends Controller
{
    /**
     * 顯示單題複習
     */
    public function show()
    {
        $question = Question::with('note')
            ->where('user_id', session('supabase_user.id'))
            ->inRandomOrder()
            ->first();

        return view('review.show', compact('question'));
    }
}
