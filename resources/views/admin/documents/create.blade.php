@extends('layouts.admin')

@section('title', 'Tải lên văn bản mới')

@section('content')
<div class="container-fluid">
    {{-- Header: Tiêu đề và nút Quay lại --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary"><i class="fas fa-cloud-upload-alt me-2"></i>Tải lên văn bản mới</h3>
        <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-secondary">Thông tin tài liệu</h5>
                </div>
                <div class="card-body p-4">
                    {{-- Form Upload --}}
                    {{-- Lưu ý: enctype="multipart/form-data" là bắt buộc để upload file --}}
                    <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nhập Tiêu đề --}}
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Tiêu đề văn bản <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="Ví dụ: Báo cáo thực tập tốt nghiệp 2025" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Chọn Loại file --}}
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label fw-bold">Loại tài liệu <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">-- Chọn loại --</option>
                                    <option value="PDF" {{ old('type') == 'PDF' ? 'selected' : '' }}>PDF Document</option>
                                    <option value="DOCX" {{ old('type') == 'DOCX' ? 'selected' : '' }}>Word Document (DOCX)</option>
                                    <option value="SLIDE" {{ old('type') == 'SLIDE' ? 'selected' : '' }}>Presentation (PPTX)</option>
                                    <option value="OTHER" {{ old('type') == 'OTHER' ? 'selected' : '' }}>Khác</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Input File --}}
                            <div class="col-md-6 mb-3">
                                <label for="file" class="form-label fw-bold">Chọn tệp tin <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required>
                                <div class="form-text small text-muted">Hỗ trợ: PDF, DOCX, PPTX (Max: 20MB)</div>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Nút Submit --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.documents.index') }}" class="btn btn-light border">Hủy bỏ</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Lưu và Đăng bài
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection