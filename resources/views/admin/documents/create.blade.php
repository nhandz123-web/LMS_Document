@extends('layouts.admin')

@section('title', 'Tải lên văn bản mới')

@section('content')
<div class="container-fluid px-4">
    {{-- Header Section --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold mb-1" style="color: #4e73df;">
                <i class="fas fa-cloud-upload-alt me-2"></i>Tải lên văn bản mới
            </h2>
            <p class="text-muted mb-0">Thêm tài liệu vào hệ thống</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.documents.index') }}" class="btn btn-light shadow-sm border">
                <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
            </a>
        </div>
    </div>

    {{-- Upload Form --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex align-items-center">
                        <div class="upload-header-icon me-3">
                            <i class="fas fa-file-upload fa-2x" style="color: #667eea;"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold" style="color: #1f2937;">Thông tin tài liệu</h5>
                            <p class="text-muted mb-0 small">Điền đầy đủ thông tin bên dưới</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        {{-- Document Title --}}
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">
                                <i class="fas fa-heading me-2 text-primary"></i>
                                Tiêu đề văn bản <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control form-control-lg @error('title') is-invalid @enderror"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Ví dụ: Báo cáo thực tập tốt nghiệp 2025"
                                required>
                            @error('title')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Đặt tên rõ ràng, dễ tìm kiếm
                            </small>
                        </div>

                        {{-- Category --}}
                        <div class="mb-4">
                            <label for="category_id" class="form-label fw-semibold">
                                <i class="fas fa-folder me-2 text-success"></i>
                                Danh mục văn bản <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg @error('category_id') is-invalid @enderror"
                                id="category_id"
                                name="category_id"
                                required>
                                <option value="">-- Chọn danh mục --</option>

                                @foreach($categories as $group)
                                <optgroup label="📁 {{ $group->name }}">
                                    @foreach($group->children as $type)
                                    <option value="{{ $type->id }}" {{ old('category_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>

                            @error('category_id')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror

                            @if($categories->isEmpty())
                            <div class="alert alert-warning mt-2 mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Chưa có danh mục nào. Vui lòng thêm danh mục trước.
                            </div>
                            @else
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Chọn danh mục phù hợp để phân loại tài liệu
                            </small>
                            @endif
                        </div>

                        <div class="row">
                            {{-- Document Type --}}
                            <div class="col-md-6 mb-4">
                                <label for="type" class="form-label fw-semibold">
                                    <i class="fas fa-file-alt me-2 text-info"></i>
                                    Loại tài liệu <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-lg @error('type') is-invalid @enderror"
                                    id="type"
                                    name="type"
                                    required>
                                    <option value="">-- Chọn loại --</option>
                                    <option value="PDF" {{ old('type') == 'PDF' ? 'selected' : '' }}>
                                        📄 PDF Document
                                    </option>
                                    <option value="DOCX" {{ old('type') == 'DOCX' ? 'selected' : '' }}>
                                        📝 Word Document (DOCX)
                                    </option>
                                    <option value="SLIDE" {{ old('type') == 'SLIDE' ? 'selected' : '' }}>
                                        📊 Presentation (PPTX)
                                    </option>
                                    <option value="OTHER" {{ old('type') == 'OTHER' ? 'selected' : '' }}>
                                        📋 Khác
                                    </option>
                                </select>
                                @error('type')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- File Upload --}}
                            <div class="col-md-6 mb-4">
                                <label for="file" class="form-label fw-semibold">
                                    <i class="fas fa-upload me-2 text-warning"></i>
                                    Chọn tệp tin <span class="text-danger">*</span>
                                </label>
                                <div class="file-upload-wrapper">
                                    <input type="file"
                                        class="form-control form-control-lg @error('file') is-invalid @enderror"
                                        id="file"
                                        name="file"
                                        accept=".pdf,.doc,.docx,.ppt,.pptx"
                                        required>
                                    <div class="file-upload-label" id="fileLabel">
                                        <i class="fas fa-cloud-upload-alt me-2"></i>
                                        Chọn file từ máy tính
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Hỗ trợ: PDF, DOCX, PPTX (Tối đa 50MB)
                                </small>
                                @error('file')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        {{-- [MỚI] CHỌN PHẠM VI HIỂN THỊ (BẮT BUỘC ĐỂ QUA VALIDATE) --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-shield-alt me-2 text-primary"></i>Phạm vi hiển thị <span class="text-danger">*</span>
                            </label>
                            <div class="card bg-light border-0 p-3">
                                <div class="d-flex gap-4">
                                    {{-- Public --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="privacy" id="privacy_public" value="public"
                                            {{ old('privacy', $doc->privacy ?? 'public') == 'public' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="privacy_public">
                                            <i class="fas fa-globe text-success me-1"></i>Công khai (Sinh viên xem được)
                                        </label>
                                    </div>

                                    {{-- Restricted --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="privacy" id="privacy_restricted" value="restricted"
                                            {{ old('privacy', $doc->privacy ?? '') == 'restricted' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="privacy_restricted">
                                            <i class="fas fa-user-tie text-danger me-1"></i>Nội bộ (Chỉ GV & Admin)
                                        </label>
                                    </div>
                                </div>
                                @error('privacy')
                                <div class="text-danger mt-2 small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- File Preview --}}
                        <div class="file-preview-area d-none mb-4" id="filePreview">
                            <div class="alert alert-light border">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="file-icon-preview me-3">
                                            <i class="fas fa-file fa-2x text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold" id="fileName"></div>
                                            <small class="text-muted" id="fileSize"></small>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile()">
                                        <i class="fas fa-times"></i> Xóa
                                    </button>
                                </div>
                                <div class="progress mt-3" style="height: 4px;">
                                    <div class="progress-bar bg-success" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-image me-2 text-info"></i>Ảnh bìa tài liệu (Tùy chọn)
                                </label>
                                <div class="d-flex align-items-center gap-4">
                                    {{-- Khung Preview ảnh --}}
                                    <div class="position-relative" style="width: 120px; height: 160px; border: 2px dashed #ddd; border-radius: 8px; overflow: hidden; background: #f8f9fa;">
                                        <img id="coverPreview" src="https://via.placeholder.com/120x160?text=No+Image"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>

                                    {{-- Input chọn ảnh --}}
                                    <div class="flex-grow-1">
                                        <input type="file" name="cover_image" id="coverInput" class="form-control" accept="image/*">
                                        <div class="form-text mt-2">
                                            Nên dùng ảnh tỉ lệ dọc (như bìa sách) để hiển thị đẹp nhất. Định dạng: JPG, PNG.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Additional Options --}}
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-cog me-2"></i>Tùy chọn bổ sung
                                </h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1">
                                    <label class="form-check-label" for="is_featured">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        Đánh dấu là tài liệu nổi bật
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="send_notification" id="send_notification" value="1" checked>
                                    <label class="form-check-label" for="send_notification">
                                        <i class="fas fa-bell text-info me-1"></i>
                                        Gửi thông báo cho người dùng
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.documents.index') }}" class="btn btn-lg btn-light border px-4">
                                <i class="fas fa-times me-2"></i>Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-lg btn-primary px-5" id="submitBtn">
                                <i class="fas fa-check-circle me-2"></i>Lưu và Đăng bài
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tips Card --}}
        </div>
    </div>
</div>
{{-- Custom CSS --}}
<style>
    .upload-header-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .file-upload-wrapper {
        position: relative;
    }

    .file-upload-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
        color: #9ca3af;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .file-upload-wrapper input[type="file"] {
        position: relative;
        z-index: 2;
        cursor: pointer;
    }

    .file-upload-wrapper input[type="file"]:hover+.file-upload-label {
        color: #4e73df;
    }

    .file-icon-preview {
        width: 50px;
        height: 50px;
        background: #f3f4f6;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }

    .form-select-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }

    .card {
        transition: all 0.3s ease;
    }

    /* Submit button loading state */
    #submitBtn.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    #submitBtn.loading::after {
        content: "";
        display: inline-block;
        width: 16px;
        height: 16px;
        margin-left: 10px;
        border: 2px solid #ffffff;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
</style>

{{-- JavaScript --}}
<script>
    // File input handling
    const fileInput = document.getElementById('file');
    const fileLabel = document.getElementById('fileLabel');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Update label
                fileLabel.innerHTML = `<i class="fas fa-check-circle me-2 text-success"></i>${file.name}`;

                // Show preview
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                filePreview.classList.remove('d-none');
            }
        });
    }

    function removeFile() {
        fileInput.value = '';
        fileLabel.innerHTML = '<i class="fas fa-cloud-upload-alt me-2"></i>Chọn file từ máy tính';
        filePreview.classList.add('d-none');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    // Form submission
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang tải lên...';
    });

    // Auto-select type based on file extension
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const extension = file.name.split('.').pop().toLowerCase();
            const typeSelect = document.getElementById('type');

            if (extension === 'pdf') {
                typeSelect.value = 'PDF';
            } else if (extension === 'docx' || extension === 'doc') {
                typeSelect.value = 'DOCX';
            } else if (extension === 'pptx' || extension === 'ppt') {
                typeSelect.value = 'SLIDE';
            }
        }
    });

    document.getElementById('coverInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('coverPreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection