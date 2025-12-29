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
        // 目前先用 session 的 user_id（你已經決定先保留）
        $userId = session('user_id');

        $notes = Note::where('user_id', $userId)
            ->latest()
            ->get();

        // 沒資料是正常狀態，view 自己處理顯示
        return view('notes.index', compact('notes'));
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
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        Note::create([
            'user_id'   => session('user_id'),
            'title'     => $request->title,
            'content'   => $request->content,
            'note_type' => 'normal',
        ]);

        return redirect()
            ->route('notes.index')
            ->with('success', '筆記已新增');
    }

    /**
     * 顯示編輯頁
     */
    public function edit(Note $note)
    {
        // 簡單防呆：不是自己的筆記就擋
        if ($note->user_id !== session('user_id')) {
            abort(403);
        }

        return view('notes.edit', compact('note'));
    }

    /**
     * 更新筆記
     */
    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== session('user_id')) {
            abort(403);
        }

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $note->update([
            'title'   => $request->title,
            'content' => $request->content,
        ]);

        return redirect()
            ->route('notes.index')
            ->with('success', '筆記已更新');
    }

    /**
     * 刪除筆記
     */
    public function destroy(Note $note)
    {
        if ($note->user_id !== session('user_id')) {
            abort(403);
        }

        $note->delete();

        return redirect()
            ->route('notes.index')
            ->with('success', '筆記已刪除');
    }
}
