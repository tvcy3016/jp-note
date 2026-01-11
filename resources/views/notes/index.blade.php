@extends('layouts.app')

@section('content')
<div class="container">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>我的筆記</h3>
    <a href="{{ route('notes.create') }}" class="btn btn-primary">
      ＋ 新增筆記
    </a>
  </div>
  {{-- 全部筆記標題 --}}
  <div class="card mb-3">
    <div class="card-body">
      <ul class="list-group list-group-flush">
        @forelse ($notes as $note)
          <li class="list-group-item">
            <a href="{{ route('notes.show', $note) }}" class="text-decoration-none">
              {{ $note->title }}
            </a>
          </li>
        @empty
          <li class="list-group-item text-muted">目前沒有任何筆記</li>
        @endforelse
      </ul>
    </div>
  </div>
</div>
@endsection
