<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>新增筆記</title>
    <link rel="stylesheet" href="{{ asset('notes.css') }}">
</head>
<body>

<h1>新增日文筆記</h1>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('notes.store') }}">
    @csrf

    <div>
        <label>標題</label><br>
        <input
            type="text"
            name="title"
            value="{{ old('title') }}"
            required
        >
    </div>

    <div>
        <label>類型</label><br>
        <select name="note_type" required>
            <option value="">請選擇</option>
            <option value="grammar" @selected(old('note_type') === 'grammar')>文法</option>
            <option value="vocabulary" @selected(old('note_type') === 'vocabulary')>單字</option>
            <option value="sentence" @selected(old('note_type') === 'sentence')>例句</option>
        </select>
    </div>

    <div>
        <label>內容</label><br>
        <textarea
            name="content"
            rows="8"
            required
        >{{ old('content') }}</textarea>
    </div>

    <button type="submit">儲存</button>
</form>

<p>
    <a href="{{ route('notes.index') }}">← 回列表</a>
</p>
<body class="notebook">

<div class="page">
    <h1>新增日文筆記</h1>

    @if ($errors->any())
        <ul class="form-errors">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form class="note-form" method="POST" action="{{ route('notes.store') }}">
        @csrf

        <div class="field">
            <label>標題</label>
            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                required
            >
        </div>

        <div class="field">
            <label>類型</label>
            <select name="note_type" required>
                <option value="">請選擇</option>
                <option value="grammar" @selected(old('note_type') === 'grammar')>文法</option>
                <option value="vocabulary" @selected(old('note_type') === 'vocabulary')>單字</option>
                <option value="sentence" @selected(old('note_type') === 'sentence')>例句</option>
            </select>
        </div>

        <div class="field">
            <label>內容</label>
            <textarea
                name="content"
                rows="8"
                required
            >{{ old('content') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit">儲存</button>
            <a href="{{ route('notes.index') }}">← 回列表</a>
        </div>
    </form>
 </div>

</body>
</html>