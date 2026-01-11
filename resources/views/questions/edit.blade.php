@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card">
    <div class="card-header">編輯題目</div>

    <div class="card-body">
      <form method="POST" action="{{ route('questions.update', $question) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label">關聯筆記</label>
          <select name="note_id" class="form-select">
            @foreach ($notes as $note)
              <option value="{{ $note->id }}" @selected($note->id === $question->note_id)>
                {{ $note->title }}（{{ $note->note_type }}）
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">題型</label>
          <select name="question_type" class="form-select">
            <option value="recall" @selected($question->question_type === 'recall')>回想題</option>
            <option value="fill" @selected($question->question_type === 'fill')>填空題</option>
            <option value="choice" @selected($question->question_type === 'choice')>單選題</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">題目內容</label>
          <textarea name="question_text" class="form-control" rows="3">{{ $question->question_text }}</textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">答案（必填）</label>
          <textarea name="answer_text" class="form-control" rows="3">{{ $question->answer_text }}</textarea>
        </div>

        <div class="mb-3" data-question-fields="choice">
          <label class="form-label">選項（每行一個）</label>
          <textarea name="choices" class="form-control" rows="4">{{ $question->choices ? implode("\n", $question->choices) : '' }}</textarea>
          <div class="form-text">僅單選題需要填寫</div>
        </div>

        <div class="mb-3">
          <label class="form-label">補充解釋（選填）</label>
          <textarea name="explanation" class="form-control" rows="3">{{ $question->explanation }}</textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">主觀複習程度</label>
          <select name="review_level" class="form-select">
            <option value="1" @selected($question->review_level === 1)>1 = 很熟</option>
            <option value="2" @selected($question->review_level === 2)>2 = 還可以</option>
            <option value="3" @selected($question->review_level === 3)>3 = 普通</option>
            <option value="4" @selected($question->review_level === 4)>4 = 不熟</option>
            <option value="5" @selected($question->review_level === 5)>5 = 很不熟</option>
          </select>
        </div>

        <button class="btn btn-primary">更新</button>
        <a href="{{ route('questions.index') }}" class="btn btn-secondary">返回</a>
      </form>
    </div>
  </div>
</div>
@endsection
