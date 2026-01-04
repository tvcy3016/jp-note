{{-- resources/views/notes/index.blade.php --}}
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>我的筆記</title>
    <link rel="stylesheet" href="{{ asset('notes.css') }}">
</head>
<body class="notebook">
    <div class="page">
        <header class="page-header">
            <h1>我的筆記</h1>
            <a class="primary-link" href="{{ route('notes.create') }}">＋ 新增筆記</a>
        </header>
        <section class="note-list">
            @forelse ($notes as $note)
                <article>
                    <h3>{{ $note->title }}</h3>
                    <p>{{ $note->content }}</p>
                    <div class="note-actions">
                        <a href="{{ route('notes.edit', $note) }}">編輯</a>
                        <form method="POST"
                              action="{{ route('notes.destroy', $note) }}"
                              onsubmit="return confirm('確定要刪除這筆筆記嗎？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">刪除</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="empty-state">目前還沒有任何筆記。</p>
            @endforelse
        </section>

        <form class="logout-form" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">登出</button>
        </form>
    </div>
</body>
</html>
