@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">題庫列表</h2>
        <a href="{{ route('questions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> 新增題目
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 35%;">題目內容</th>
                            <th style="width: 10%;">類型</th>
                            <th style="width: 20%;">來源筆記</th>
                            <th style="width: 15%;">熟悉度 (SRS)</th>
                            <th class="text-end pe-4" style="width: 20%;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-start flex-column">
                                        <div class="fw-bold text-dark text-break">
                                            {{ Str::limit($question->question_text, 40) }}
                                        </div>
                                        <div class="text-muted small mt-1">
                                            <i class="bi bi-arrow-return-right me-1"></i>
                                            {{ Str::limit($question->answer_text, 20) }}
                                        </div>

                                        @if($question->parent_id)
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill mt-2">
                                                <i class="bi bi-robot me-1"></i> AI 變形題
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($question->question_type === 'vocabulary')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success">
                                            單字
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary">
                                            文法
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($question->note)
                                        <a href="{{ route('notes.show', $question->note) }}" class="text-decoration-none text-secondary d-inline-block text-truncate" style="max-width: 150px;">
                                            <i class="bi bi-journal-text me-1"></i>
                                            {{ $question->note->title }}
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <div class="progress" style="height: 6px; width: 80px;">
                                            @php
                                                $progress = min(100, ($question->ease_factor - 1.3) / (2.5 - 1.3) * 50 + ($question->repetitions * 10));
                                                $colorClass = $progress < 30 ? 'bg-danger' : ($progress < 70 ? 'bg-warning' : 'bg-success');
                                            @endphp
                                            <div class="progress-bar {{ $colorClass }}" role="progressbar" style="width: {{ $progress }}%"></div>
                                        </div>
                                        <span class="text-muted small" style="font-size: 0.75rem;">
                                            間隔: {{ $question->interval_days }} 天
                                        </span>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <form action="{{ route('questions.generate', $question->id) }}" method="POST" class="d-inline"
                                              x-data="{ loading: false }" 
                                              @submit="loading = true">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary btn-sm" 
                                                    title="AI 生成變體"
                                                    :disabled="loading">
                                                
                                                <span x-show="!loading">
                                                    <i class="bi bi-magic me-1"></i> 變形
                                                </span>
                                                
                                                <span x-show="loading" style="display: none;">
                                                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                                    生成中...
                                                </span>
                                            </button>
                                        </form>

                                        <a href="{{ route('questions.edit', $question) }}" class="btn btn-outline-secondary btn-sm" title="編輯">
                                            <i class="bi bi-pencil"></i> 編輯
                                        </a>
                                        
                                        <form action="{{ route('questions.destroy', $question) }}" method="POST" class="d-inline" onsubmit="return confirm('確定要刪除此題目嗎？這將無法復原。');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="刪除">
                                                <i class="bi bi-trash"></i> 刪除
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted mb-2">
                                        <i class="bi bi-clipboard-x" style="font-size: 2rem;"></i>
                                    </div>
                                    <p class="text-muted mb-0">目前還沒有題目，請點擊右上方按鈕新增。</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($questions->hasPages())
                <div class="card-footer bg-white border-top-0 py-3">
                    {{ $questions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection