@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>{{ $note->title }}</h3>
    <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">返回列表</a>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <p class="text-muted small mb-2">
        類型：{{ $note->note_type }}
      </p>

      @if ($note->note_type === 'vocabulary')
        <p>讀音：{{ $note->reading }}</p>
        <p>意思：{{ $note->meaning }}</p>
      @elseif ($note->note_type === 'grammar')
        <p>用法：{{ $note->usage }}</p>
        <p>例句：{{ $note->example }}</p>
      @elseif ($note->note_type === 'mistake')
        <p>題目：{{ $note->question }}</p>
        <p>答案：{{ $note->answer }}</p>
        <p>解釋：{{ $note->explanation }}</p>
        <p>難度：{{ $note->difficulty }}</p>
      @endif

      @if ($note->content)
        <hr>
        <p class="text-muted">{{ $note->content }}</p>
      @endif

      <div class="mt-3">
        <a href="{{ route('notes.edit', $note) }}" class="btn btn-sm btn-outline-secondary">
          編輯
        </a>

        <form action="{{ route('notes.destroy', $note) }}"
              method="POST"
              class="d-inline">
          @csrf
          @method('DELETE')
          <button class="btn btn-sm btn-outline-danger"
                  onclick="return confirm('確定要刪除？')">
            刪除
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection