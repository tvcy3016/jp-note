{{-- resources/views/notes/index.blade.php --}}

<h1>我的筆記</h1>

<p>
    <a href="{{ route('notes.create') }}">＋ 新增筆記</a>
</p>

@forelse ($notes as $note)
    <article style="border:1px solid #ccc; padding:12px; margin-bottom:12px;">
        <h3>{{ $note->title }}</h3>
        <p>{{ $note->content }}</p>

        <a href="{{ route('notes.edit', $note) }}">編輯</a>

        <form method="POST"
              action="{{ route('notes.destroy', $note) }}"
              style="display:inline"
              onsubmit="return confirm('確定要刪除這筆筆記嗎？')">
            @csrf
            @method('DELETE')
            <button type="submit">刪除</button>
        </form>
    </article>
@empty
    <p>目前還沒有任何筆記。</p>
@endforelse
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">登出</button>
</form>
