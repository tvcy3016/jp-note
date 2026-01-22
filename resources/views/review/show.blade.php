@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">每日複習</h2>
            <p class="text-muted mb-0">保持節奏，鞏固記憶！</p>
        </div>
        <div class="text-end">
            <span class="badge bg-primary rounded-pill fs-6 px-3 py-2">
                剩餘 {{ $dueCount }} 題
            </span>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4 mb-4 overflow-hidden" style="min-height: 300px;">
                <div class="card-header bg-white border-0 pt-4 px-4 text-center">
                    <span class="badge bg-light text-dark border">
                        {{ $question->question_type === 'vocabulary' ? '單字' : '文法' }}
                    </span>
                    @if($question->note)
                        <small class="text-muted d-block mt-2">
                            來自筆記：{{ Str::limit($question->note->title ?? '無標題', 20) }}
                        </small>
                    @endif
                </div>

                <div class="card-body d-flex align-items-center justify-content-center flex-column p-5">
                    <h1 class="display-4 fw-bold text-center mb-4 text-dark">
                        {{ $question->question_text }}
                    </h1>
                    
                    @if(isset($question->choices) && count($question->choices) > 0)
                        <div class="d-grid gap-2 w-100">
                            @foreach($question->choices as $choice)
                                <div class="btn btn-outline-secondary text-start disabled-option">
                                    {{ $choice }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="card-footer bg-white border-0 pb-4"></div>
            </div>

            <div x-data="{ showAnswer: false }">
                <button 
                    @click="showAnswer = true" 
                    x-show="!showAnswer" 
                    class="btn btn-primary w-100 py-3 rounded-3 shadow-sm fw-bold fs-5 transition-btn">
                    查看答案
                </button>

                <div x-show="showAnswer" style="display: none;" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0">
                    
                    <div class="card-body p-4 text-center">
                        <h5 class="text-muted mb-1">正確答案</h5>
                        <h3 class="text-success fw-bold mb-3">{{ $question->answer_text }}</h3>
                        
                        @if($question->explanation)
                            <hr class="my-3 opacity-25">
                            <p class="text-secondary mb-0 text-start">
                                <strong class="d-block mb-1">💡 解析：</strong>
                                {{ $question->explanation }}
                            </p>
                        @endif

                        @if($question->note)
                            <div class="mt-4 pt-3 border-top">
                                <a href="{{ route('notes.show', $question->note->id) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    📄 複習原始筆記：{{ Str::limit($question->note->title, 15) }}
                                </a>
                            </div>
                        @endif
                    </div>

                    <p class="text-center text-muted small mb-2">這題對你來說...</p>
                    <form action="{{ route('review.update', $question->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-2">
                            <div class="col-3">
                                <button type="submit" name="quality" value="0" class="btn btn-outline-danger w-100 py-3 h-100 d-flex flex-column align-items-center justify-content-center">
                                    <span class="fs-4 d-block mb-1">忘了</span>
                                    <span class="small fw-bold">忘記</span>
                                </button>
                            </div>
                            <div class="col-3">
                                <button type="submit" name="quality" value="3" class="btn btn-outline-warning w-100 py-3 h-100 d-flex flex-column align-items-center justify-content-center">
                                    <span class="fs-4 d-block mb-1">好難</span>
                                    <span class="small fw-bold">困難</span>
                                </button>
                            </div>
                            <div class="col-3">
                                <button type="submit" name="quality" value="4" class="btn btn-outline-info w-100 py-3 h-100 d-flex flex-column align-items-center justify-content-center">
                                    <span class="fs-4 d-block mb-1">普通</span>
                                    <span class="small fw-bold">記得</span>
                                </button>
                            </div>
                            <div class="col-3">
                                <button type="submit" name="quality" value="5" class="btn btn-outline-success w-100 py-3 h-100 d-flex flex-column align-items-center justify-content-center">
                                    <span class="fs-4 d-block mb-1">超簡單</span>
                                    <span class="small fw-bold">秒答</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-btn:hover {
        transform: translateY(-2px);
    }
    .disabled-option {
        pointer-events: none; /* 讓選項純展示，不可點擊 */
    }
</style>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection