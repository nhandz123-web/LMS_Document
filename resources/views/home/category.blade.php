@extends('layouts.app')

@section('title', $category->name)

@section('content')

{{-- HEADER DANH MỤC --}}
<div class="bg-white p-4 rounded-4 shadow-sm mb-4 border-start border-5 border-primary" style="border-color: var(--accent)!important;">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <span class="text-muted small text-uppercase fw-bold ls-1">Danh mục tài liệu</span>
            <h2 class="fw-bold text-dark mb-0 mt-1">{{ $category->name }}</h2>
            @if($category->parent)
                <small class="text-muted"><i class="fas fa-level-up-alt fa-rotate-90 me-1"></i>Thuộc nhóm: {{ $category->parent->name }}</small>
            @endif
        </div>
        <div class="text-end d-none d-md-block">
            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" 
                 style="width: 60px; height: 60px; color: var(--accent);">
                <i class="fas fa-folder-open fa-2x"></i>
            </div>
        </div>
    </div>
</div>

{{-- DANH SÁCH VĂN BẢN --}}
<div class="row">
    @forelse($docs as $doc)
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card doc-card h-100 position-relative">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between mb-3">
                    {{-- Icon loại file --}}
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        @if($doc->type == 'PDF') <i class="fas fa-file-pdf fa-lg text-danger"></i>
                        @elseif($doc->type == 'DOCX') <i class="fas fa-file-word fa-lg text-primary"></i>
                        @else <i class="fas fa-file-alt fa-lg text-secondary"></i>
                        @endif
                    </div>
                </div>
                
                <h6 class="card-title fw-bold mb-2">
                    <a href="{{ route('document.show', $doc->id) }}" class="text-decoration-none text-dark stretched-link link-hover">
                        {{ \Illuminate\Support\Str::limit($doc->title, 50) }}
                    </a>
                </h6>
                
                <div class="d-flex align-items-center text-muted small mb-2">
                    <i class="far fa-user me-1"></i> {{ \Illuminate\Support\Str::limit($doc->author->fullname ?? 'Unknown', 15) }}
                </div>
            </div>
            
            <div class="card-footer bg-white border-top-0 pt-0 pb-3">
                <div class="d-flex justify-content-between align-items-center small text-muted border-top pt-2">
                    <span><i class="far fa-clock me-1"></i>{{ $doc->created_at->format('d/m/Y') }}</span>
                    <span class="text-primary fw-bold" style="color: var(--accent)!important;">Xem &rarr;</span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 py-5 text-center">
        <div class="empty-state">
            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="Empty" width="100" class="mb-3 opacity-50">
            <h5 class="text-muted">Chưa có tài liệu nào trong danh mục này</h5>
            <a href="{{ route('home') }}" class="btn btn-outline-primary mt-3">Quay lại trang chủ</a>
        </div>
    </div>
    @endforelse
</div>

{{-- Phân trang --}}
<div class="d-flex justify-content-center mt-4">
    {{ $docs->links() }}
</div>

@endsection