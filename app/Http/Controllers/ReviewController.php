<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Services\SRSService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $srsService;

    public function __construct(SRSService $srsService)
    {
        $this->srsService = $srsService;
    }

    public function index()
    {
        $userId = session('supabase_user.id');

        // 1. 撈取一題「到期」的題目 (加上 with('note') 預先載入筆記)
        $question = Question::with('note')
            ->where('user_id', $userId)
            ->where('next_review_at', '<=', now())
            ->orderBy('next_review_at', 'asc')
            ->first();

        // 2. 統計還有幾題需要複習
        $dueCount = Question::where('user_id', $userId)
            ->where('next_review_at', '<=', now())
            ->count();

        // 如果沒有題目了 (代表今日複習完成)
        if (!$question) {
            // [關鍵修正] 新增這段邏輯：找出「未來」最近的一筆複習時間
            $nextReview = Question::where('user_id', $userId)
                ->where('next_review_at', '>', now()) // 找未來的
                ->orderBy('next_review_at', 'asc')    // 找最近的
                ->first();

            // 取得時間物件，如果完全沒題目則為 null
            $nextReviewDate = $nextReview ? $nextReview->next_review_at : null;

            // [關鍵修正] 記得用 compact 將變數傳給 View
            return view('review.completed', compact('nextReviewDate'));
        }

        return view('review.show', compact('question', 'dueCount'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'quality' => 'required|integer|min:0|max:5',
        ]);

        // 修正：驗證使用者權限時也使用 Session ID
        $userId = session('supabase_user.id');
        if ($question->user_id !== $userId) {
            abort(403);
        }

        // 準備當前狀態
        $currentStats = [
            'ease_factor' => $question->ease_factor,
            'repetitions' => $question->repetitions,
            'interval_days' => $question->interval_days,
        ];

        // 計算新狀態
        $newStats = $this->srsService->calculateNextReview($currentStats, $validated['quality']);

        // 更新資料庫
        $question->update($newStats);

        return redirect()->route('review.index')->with('status', '已記錄學習進度！');
    }
}