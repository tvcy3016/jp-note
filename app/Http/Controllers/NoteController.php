<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * 筆記列表
     */
    public function index(Request $request)
    {
        $latestNotes = Note::latest()
            ->where('user_id', session('supabase_user.id'))
            ->take(5)
            ->get();

        $notes = Note::where('user_id', session('supabase_user.id'))
            ->when($request->type, function ($q) use ($request) {
                $q->where('note_type', $request->type);
            })
            ->latest()
            ->get();

        return view('notes.index', compact('latestNotes', 'notes'));
    }


    /**
     * 顯示新增筆記頁
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * 新增筆記
     */
    public function store(Request $request)
    {
        $data = $request->only([
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
        ]);

        $data['user_id'] = session('supabase_user.id');

        Note::create($data);

        return redirect()->route('notes.index');
    }


    /**
     * 顯示編輯頁
     */
    public function edit(Note $note)
    {
        // 簡單防呆：不是自己的筆記就擋
        if ($note->user_id !== session('supabase_user.id')) {
            abort(403);
        }

        return view('notes.edit', compact('note'));
    }

    /**
     * 更新筆記
     */
    public function update(Request $request, Note $note)
    {
        $data = $request->only([
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
        ]);

        $note->update($data);

        return redirect()->route('notes.index');
    }


    /**
     * 刪除筆記
     */
    public function destroy(Note $note)
    {
        if ($note->user_id !== session('supabase_user.id')) {
            abort(403);
        }

        $note->delete();

        return redirect()
            ->route('notes.index')
            ->with('success', '筆記已刪除');
    }
}
