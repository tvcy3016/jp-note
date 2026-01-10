@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card">
    <div class="card-header">新增筆記</div>

    <div class="card-body">
      <form method="POST" action="{{ route('notes.store') }}">
        @csrf

        <div class="mb-3">
          <label class="form-label">筆記類型</label>
          <select name="note_type" class="form-select">
            <option value="vocabulary">單字</option>
            <option value="grammar">文法</option>
            <option value="mistake">錯題</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">標題</label>
          <input type="text" name="title" class="form-control">
        </div>

        {{-- 單字 --}}
        <div data-note-fields="vocabulary">
          <div class="mb-3">
            <label class="form-label">讀音</label>
            <input type="text" name="reading" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">意思</label>
            <input type="text" name="meaning" class="form-control">
          </div>
        </div>


        {{-- 文法 --}}
        <div data-note-fields="grammar">
          <div class="mb-3">
            <label class="form-label">用法</label>
            <textarea name="usage" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">例句</label>
            <textarea name="example" class="form-control"></textarea>
          </div>
        </div>

        {{-- 錯題 --}}
        <div data-note-fields="mistake">
          <div class="mb-3">
            <label class="form-label">題目</label>
            <textarea name="question" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">答案</label>
            <textarea name="answer" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">解釋</label>
            <textarea name="explanation" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">自覺難度</label>
            <select name="difficulty" class="form-select">
              <option value="1">簡單</option>
              <option value="2">普通</option>
              <option value="3">困難</option>
            </select>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">備註</label>
          <textarea name="content" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">儲存</button>
        <a href="{{ route('notes.index') }}" class="btn btn-secondary">返回</a>
      </form>
    </div>
  </div>
</div>
@endsection
