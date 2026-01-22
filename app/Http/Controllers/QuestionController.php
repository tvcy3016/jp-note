<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Question;
use App\Services\GeminiService; // 引入 AI 服務
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected $geminiService;

    // 注入 GeminiService
    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * 題庫列表
     */
    public function index()
    {
        $questions = Question::with('note')
            ->where('user_id', session('supabase_user.id'))
            ->latest()
            ->paginate(10); // 修正：使用分頁 (原本是 get())

        return view('questions.index', compact('questions'));
    }

    /**
     * AI 生成變體題目 (Phase 3 核心功能)
     */
    public function generateVariant(Request $request, Question $question)
    {
        // 1. 安全檢查
        if ($question->user_id !== session('supabase_user.id')) {
            abort(403);
        }

        // 2. 準備上下文
        $noteContent = $question->note ? $question->note->content : '';

        // 3. 呼叫 AI
        $variantData = $this->geminiService->generateVariant(
            $question->question_text,
            $question->answer_text,
            $noteContent
        );

        if (!$variantData) {
            return back()->with('error', 'AI 生成失敗，請稍後再試。');
        }

        // 4. 存入新題目
        Question::create([
            'user_id' => $question->user_id,
            'note_id' => $question->note_id,
            'parent_id' => $question->id, // 標記來源題目
            'question_type' => $question->question_type,
            'question_text' => $variantData['question_text'],
            'answer_text' => $variantData['answer_text'],
            'choices' => $variantData['choices'] ?? [],
            'explanation' => $variantData['explanation'] ?? null,
            // SRS 初始狀態
            'ease_factor' => 2.5,
            'interval_days' => 0,
            'repetitions' => 0,
            'next_review_at' => now(),
        ]);

        return redirect()->route('questions.index')
            ->with('status', '✨ AI 變形題目已生成！');
    }

    /**
     * 顯示新增題目頁
     */
    public function create()
    {
        $notes = Note::where('user_id', session('supabase_user.id'))
            ->latest()
            ->get();

        return view('questions.create', compact('notes'));
    }

    /**
     * 新增題目
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'note_id',
            'question_type',
            'question_text',
            'answer_text',
            'explanation',
        ]);

        $note = Note::where('id', $data['note_id'] ?? null)
            ->where('user_id', session('supabase_user.id'))
            ->first();

        if (!$note) {
            abort(403);
        }

        $data['user_id'] = session('supabase_user.id');
        $data['review_level'] = $this->sanitizeReviewLevel($request->input('review_level'));
        $data['choices'] = $this->normalizeChoices(
            $request->input('choices'),
            $data['question_type'] ?? null
        );

        Question::create($data);

        return redirect()->route('questions.index');
    }

    /**
     * 顯示編輯題目頁
     */
    public function edit(Question $question)
    {
        if ($question->user_id !== session('supabase_user.id')) {
            abort(403);
        }

        $notes = Note::where('user_id', session('supabase_user.id'))
            ->latest()
            ->get();

        return view('questions.edit', compact('question', 'notes'));
    }

    /**
     * 更新題目
     */
    public function update(Request $request, Question $question)
    {
        if ($question->user_id !== session('supabase_user.id')) {
            abort(403);
        }

        $data = $request->only([
            'note_id',
            'question_type',
            'question_text',
            'answer_text',
            'explanation',
        ]);

        $note = Note::where('id', $data['note_id'] ?? null)
            ->where('user_id', session('supabase_user.id'))
            ->first();

        if (!$note) {
            abort(403);
        }

        $data['review_level'] = $this->sanitizeReviewLevel($request->input('review_level'));
        $data['choices'] = $this->normalizeChoices(
            $request->input('choices'),
            $data['question_type'] ?? null
        );

        $question->update($data);

        return redirect()->route('questions.index');
    }

    /**
     * 刪除題目
     */
    public function destroy(Question $question)
    {
        if ($question->user_id !== session('supabase_user.id')) {
            abort(403);
        }

        $question->delete();

        return redirect()
            ->route('questions.index')
            ->with('success', '題目已刪除');
    }

    private function normalizeChoices(?string $choicesInput, ?string $questionType): ?array
    {
        if ($questionType !== 'choice') {
            return null;
        }

        $choices = collect(preg_split('/\r\n|\r|\n/', $choicesInput ?? ''))
            ->map(fn ($choice) => trim($choice))
            ->filter()
            ->values()
            ->all();

        return $choices ?: null;
    }

    private function sanitizeReviewLevel($level): int
    {
        $level = (int) $level;

        if ($level < 1 || $level > 5) {
            return 3;
        }

        return $level;
    }
}