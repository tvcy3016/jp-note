@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card">
    <div class="card-header">新增題目</div>

    <div class="card-body">
      @if ($notes->isEmpty())
        <div class="alert alert-warning">
          目前沒有可關聯的筆記，請先建立筆記。
        </div>
        <a href="{{ route('notes.create') }}" class="btn btn-primary">前往新增筆記</a>
        <a href="{{ route('questions.index') }}" class="btn btn-secondary">返回</a>
      @else
        <form method="POST" action="{{ route('questions.store') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">關聯筆記</label>
            <select name="note_id" class="form-select">
              @foreach ($notes as $note)
                <option value="{{ $note->id }}">
                  {{ $note->title }}（{{ $note->note_type }}）
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">題型</label>
            <select name="question_type" class="form-select">
              <option value="recall">回想題</option>
              <option value="fill">填空題</option>
              <option value="choice">單選題</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">題目內容</label>
            <textarea name="question_text" class="form-control" rows="3"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">答案（必填）</label>
            <textarea name="answer_text" class="form-control" rows="3"></textarea>
          </div>

          <div class="mb-3" data-question-fields="choice">
            <label class="form-label">選項（每行一個）</label>
            <textarea name="choices" class="form-control" rows="4"></textarea>
            <div class="form-text">僅單選題需要填寫</div>
          </div>

          <div class="mb-3">
            <label class="form-label">補充解釋（選填）</label>
            <textarea name="explanation" class="form-control" rows="3"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">主觀複習程度</label>
            <select name="review_level" class="form-select">
              <option value="1">1 = 很熟</option>
              <option value="2">2 = 還可以</option>
              <option value="3" selected>3 = 普通</option>
              <option value="4">4 = 不熟</option>
              <option value="5">5 = 很不熟</option>
            </select>
          </div>

          <button class="btn btn-primary">儲存</button>
          <a href="{{ route('questions.index') }}" class="btn btn-secondary">返回</a>
        </form>
      @endif
    </div>
  </div>
</div>
@endsection
