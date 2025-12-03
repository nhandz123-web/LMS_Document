@extends('layouts.app')

@section('title', $doc->title)

@section('content')
<div class="row">
    {{-- CỘT TRÁI: HIỂN THỊ NỘI DUNG FILE (PREVIEW) --}}
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="fw-bold mb-0 text-primary"><i class="fas fa-book-open me-2"></i>Nội dung tài liệu</h5>
            </div>
            {{-- Thay thế đoạn iframe cũ bằng đoạn này --}}
            <div class="card-body p-0 position-relative overflow-hidden" style="background: #525659; height: 600px;">
                @if($doc->drive_path)
                <iframe src="https://drive.google.com/file/d/{{ $doc->drive_path }}/preview"
                    style="border: none; 
                       width: 125%; /* Phóng to khung ngang */
                       height: 125%; /* Phóng to khung dọc */
                       transform: scale(0.8); /* Thu nhỏ nội dung lại còn 80% */
                       transform-origin: 0 0; /* Căn thu nhỏ từ góc trên trái */
                       "
                    allow="autoplay">
                </iframe>
                @else
                <div class="d-flex flex-column align-items-center justify-content-center h-100 text-white-50">
                    <i class="fas fa-file-excel fa-3x mb-3"></i>
                    <p>Không có bản xem trước.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- CỘT PHẢI: THÔNG TIN CHI TIẾT & TẢI VỀ --}}
    <div class="col-lg-4">

        {{-- Card 1: Thông tin chính --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h4 class="fw-bold text-dark mb-3">{{ $doc->title }}</h4>

                <div class="mb-4">
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill">
                        {{ $doc->category->name ?? 'Chưa phân loại' }}
                    </span>
                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3 py-2 rounded-pill ms-2">
                        {{ $doc->type }}
                    </span>
                </div>

                {{-- Nút Tải xuống --}}
                <div class="d-grid gap-2">
                    <a href="https://drive.google.com/file/d/{{ $doc->drive_path }}/view?usp=sharing" target="_blank" class="btn btn-primary btn-lg fw-bold">
                        <i class="fas fa-download me-2"></i>Tải xuống tài liệu
                    </a>
                </div>
            </div>
        </div>

        {{-- Card 2: Metadata (Thông tin bổ sung) --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold">Thông tin chi tiết</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <span class="text-muted"><i class="fas fa-user me-2"></i>Người đăng</span>
                    <span class="fw-bold text-dark">{{ $doc->author->fullname ?? 'Ẩn danh' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <span class="text-muted"><i class="fas fa-calendar-alt me-2"></i>Ngày đăng</span>
                    <span class="fw-bold text-dark">{{ $doc->created_at->format('d/m/Y') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <span class="text-muted"><i class="fas fa-eye me-2"></i>Lượt xem</span>
                    {{-- Giả định, sau này bạn có thể làm tính năng đếm view --}}
                    <span class="fw-bold text-dark">--</span>
                </li>
            </ul>
        </div>

        {{-- Card 3: Gợi ý tài liệu liên quan --}}
        {{-- (Logic này cần bổ sung ở Controller nếu muốn) --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">Có thể bạn quan tâm</div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    {{-- Ví dụ tĩnh, bạn có thể loop data thật vào đây --}}
                    <div class="p-4 text-center text-muted small">
                        Đang cập nhật thêm tài liệu cùng chuyên mục...
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection