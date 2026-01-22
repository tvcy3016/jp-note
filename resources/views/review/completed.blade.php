@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card shadow border-0 rounded-4 p-5">
                <div class="card-body">

                    <h2 class="fw-bold text-dark mb-3">太棒了！</h2>
                    <p class="text-muted fs-5 mb-4">
                        您已經完成了今天所有的複習進度。
                    </p>

                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div class="d-flex justify-content-center gap-4 text-secondary">
                            <div>
                                <small class="d-block text-uppercase text-muted" style="font-size: 0.7rem;">今日完成</small>
                                <span class="fw-bold fs-4 text-primary">完成</span>
                            </div>
                            <span class="fw-bold fs-4 text-success">
                                <small class="d-block text-uppercase text-muted" style="font-size: 0.7rem;">下次複習</small>
                                @if($nextReviewDate)
                                    {{ $nextReviewDate->diffForHumans() }}
                                    
                                    <div style="font-size: 0.8rem;" class="text-muted fw-normal mt-1">
                                        ({{ $nextReviewDate->format('m/d H:i') }})
                                    </div>
                                @else
                                    暫無排程
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('notes.index') }}" class="btn btn-outline-primary btn-lg rounded-pill">
                            回去整理筆記
                        </a>
                        <a href="{{ route('questions.create') }}" class="btn btn-primary btn-lg rounded-pill">
                            手動新增題目
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection