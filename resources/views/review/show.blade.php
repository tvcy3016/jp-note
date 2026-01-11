@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>複習模式</h3>
    <a href="{{ route('review.show') }}" class="btn btn-outline-primary btn-sm">換一題</a>
  </div>

  @if (!$question)
    <div class="alert alert-warning">目前沒有可複習的題目。</div>
    <a href="{{ route('questions.create') }}" class="btn btn-primary">前往新增題目</a>
  @else
    @php
      $typeLabels = [
        'recall' => '回想',
        'fill' => '填空',
        'choice' => '單選',
      ];
    @endphp

    <div class="card">
      <div class="card-body">
        <p class="text-muted small">
          題型：{{ $typeLabels[$question->question_type] ?? $question->question_type }}
        </p>

        <h5 class="card-title">{{ $question->question_text }}</h5>

        @if ($question->question_type === 'choice' && $question->choices)
          <ul class="list-group list-group-flush mb-3">
            @foreach ($question->choices as $choice)
              <li class="list-group-item">{{ $choice }}</li>
            @endforeach
          </ul>
        @endif

        <button class="btn btn-outline-secondary" type="button" data-action="toggle-answer">
          顯示答案
        </button>

        <div class="mt-3" data-answer-block style="display: none;">
          <div class="card border-light">
            <div class="card-body">
              <p><strong>正解：</strong>{{ $question->answer_text }}</p>

              @if ($question->explanation)
                <p><strong>補充：</strong>{{ $question->explanation }}</p>
              @endif

              <p class="mb-0"><strong>複習程度：</strong>{{ $question->review_level }}</p>

              @if ($question->note)
                <a href="{{ route('notes.edit', $question->note) }}" class="btn btn-link p-0 mt-2">
                  查看關聯筆記
                </a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('[data-action="toggle-answer"]');
    const answerBlock = document.querySelector('[data-answer-block]');

    if (!button || !answerBlock) return;

    button.addEventListener('click', () => {
      const isHidden = answerBlock.style.display === 'none';
      answerBlock.style.display = isHidden ? 'block' : 'none';
      button.textContent = isHidden ? '隱藏答案' : '顯示答案';
    });
  });
</script>
@endsection
