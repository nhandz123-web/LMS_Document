@extends('layouts.admin')

@section('title', 'Chỉnh sửa văn bản')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary"><i class="fas fa-edit me-2"></i>Chỉnh sửa văn bản</h3>
        <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Quay lại
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    {{-- Form Update --}}
                    <form action="{{ route('admin.documents.update', $doc->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- BẮT BUỘC ĐỂ GỌI UPDATE --}}

                        {{-- Tiêu đề --}}
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Tiêu đề văn bản <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ old('title', $doc->title) }}" required>
                            <div class="form-text text-muted">Đổi tiêu đề ở đây sẽ tự động đổi tên file trên Google Drive.</div>
                        </div>

                        {{-- Thêm vào form trong edit.blade.php --}}

                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-bold">Danh mục văn bản <span class="text-danger">*</span></label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>

                                @foreach($categories as $group)
                                <optgroup label="{{ $group->name }}">
                                    @foreach($group->children as $type)
                                    <option value="{{ $type->id }}"
                                        {{-- Logic để selected: Nếu đang sửa và ID trùng khớp --}}
                                        {{ (old('category_id', $doc->category_id) == $type->id) ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </div>

                        {{-- Loại file --}}
                        <div class="mb-3">
                            <label for="type" class="form-label fw-bold">Loại tài liệu <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="PDF" {{ $doc->type == 'PDF' ? 'selected' : '' }}>PDF Document</option>
                                <option value="DOCX" {{ $doc->type == 'DOCX' ? 'selected' : '' }}>Word Document</option>
                                <option value="SLIDE" {{ $doc->type == 'SLIDE' ? 'selected' : '' }}>Presentation</option>
                                <option value="OTHER" {{ $doc->type == 'OTHER' ? 'selected' : '' }}>Khác</option>
                            </select>
                        </div>

                        {{-- File hiện tại --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">File đính kèm</label>

                            @if($doc->drive_path)
                            <div class="alert alert-light border d-flex align-items-center mb-2">
                                <i class="fas fa-file-check text-success fa-2x me-3"></i>
                                <div>
                                    <strong>File hiện tại trên hệ thống</strong><br>
                                    <small class="text-muted">ID Drive: {{ $doc->drive_path }}</small>
                                </div>
                                <a href="https://drive.google.com/file/d/{{ $doc->drive_path }}/view" target="_blank" class="btn btn-sm btn-outline-primary ms-auto">
                                    <i class="fas fa-external-link-alt me-1"></i>Xem file
                                </a>
                            </div>
                            @endif

                            <label class="form-label small text-muted mt-2">Chọn file mới nếu muốn thay thế (Bỏ trống để giữ nguyên file cũ)</label>
                            <input type="file" class="form-control" name="file">
                        </div>

                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.documents.index') }}" class="btn btn-light border">Hủy bỏ</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection