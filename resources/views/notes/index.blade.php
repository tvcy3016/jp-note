@extends('layouts.app')

@section('content')
<div class="container">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>我的筆記</h3>
    <a href="{{ route('notes.create') }}" class="btn btn-primary">
      ＋ 新增筆記
    </a>
  </div>

  {{-- 最新五筆 --}}
  <div class="card mb-4">
    <div class="card-header">最新五筆</div>
    <ul class="list-group list-group-flush">
      @forelse ($latestNotes as $note)
        <li class="list-group-item">
          <strong>{{ $note->title }}</strong>
          <span class="text-muted small">（{{ $note->note_type }}）</span>
        </li>
      @empty
        <li class="list-group-item text-muted">尚無筆記</li>
      @endforelse
    </ul>
  </div>

  {{-- 全部筆記 --}}
  @forelse ($notes as $note)
    <div class="card mb-3">
      <div class="card-body">
        <h5 class="card-title">{{ $note->title }}</h5>

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
  @empty
    <p class="text-muted">目前沒有任何筆記</p>
  @endforelse

</div>
@endsection
