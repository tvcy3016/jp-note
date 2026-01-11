@extends('layouts.app')

@section('content')
<div class="container">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>題庫管理</h3>
    <a href="{{ route('questions.create') }}" class="btn btn-primary">
      ＋ 新增題目
    </a>
  </div>

  @php
    $typeLabels = [
      'recall' => '回想',
      'fill' => '填空',
      'choice' => '單選',
    ];
  @endphp

  @forelse ($questions as $question)
    <div class="card mb-3">
      <div class="card-body">
        <h5 class="card-title">
          {{ \Illuminate\Support\Str::limit($question->question_text, 80) }}
        </h5>

        <p class="text-muted small mb-2">
          題型：{{ $typeLabels[$question->question_type] ?? $question->question_type }}
          <span class="ms-2">複習程度：{{ $question->review_level }}</span>
        </p>

        <p class="text-muted small mb-2">
          關聯筆記：{{ $question->note?->title ?? '（未找到筆記）' }}
          <span class="ms-2">建立時間：{{ $question->created_at?->format('Y-m-d') }}</span>
        </p>

        <div class="mt-3">
          <a href="{{ route('questions.edit', $question) }}" class="btn btn-sm btn-outline-secondary">
            編輯
          </a>

          <form action="{{ route('questions.destroy', $question) }}"
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
    <p class="text-muted">目前沒有任何題目</p>
  @endforelse

</div>
@endsection
