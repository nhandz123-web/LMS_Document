@extends('layouts.admin')

@section('title', 'Chỉnh sửa văn bản')

@section('content')
<div class="container-fluid px-4">
    {{-- Header Section --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold mb-1" style="color: #4e73df;">
                <i class="fas fa-edit me-2"></i>Chỉnh sửa văn bản
            </h2>
            <p class="text-muted mb-0">Cập nhật thông tin tài liệu #{{ $doc->id }}</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.documents.index') }}" class="btn btn-light shadow-sm border">
                <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
            </a>
        </div>
    </div>

    {{-- Edit Form --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Current File Info Card --}}
            @if($doc->drive_path)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="file-icon-large">
                                @if(strtoupper($doc->type) == 'PDF')
                                <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                @elseif(strtoupper($doc->type) == 'DOCX')
                                <i class="fas fa-file-word fa-3x text-primary"></i>
                                @elseif(strtoupper($doc->type) == 'SLIDE')
                                <i class="fas fa-file-powerpoint fa-3x text-warning"></i>
                                @else
                                <i class="fas fa-file fa-3x text-secondary"></i>
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="fw-bold mb-1">{{ $doc->title }}</h5>
                            <div class="text-muted small">
                                <i class="fas fa-tag me-2"></i>{{ strtoupper($doc->type) }}
                                <span class="mx-2">•</span>
                                <i class="fas fa-calendar me-2"></i>{{ $doc->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="text-muted small mt-1">
                                <i class="fas fa-key me-2"></i>
                                <code class="text-muted">Drive ID: {{ $doc->drive_path }}</code>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="https://drive.google.com/file/d/{{ $doc->drive_path }}/view"
                                target="_blank"
                                class="btn btn-primary">
                                <i class="fas fa-external-link-alt me-2"></i>Xem file gốc
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Edit Form Card --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex align-items-center">
                        <div class="edit-header-icon me-3">
                            <i class="fas fa-pen-to-square fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold" style="color: #1f2937;">Cập nhật thông tin</h5>
                            <p class="text-muted mb-0 small">Chỉnh sửa các trường bên dưới</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.documents.update', $doc->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
                        @csrf
                        @method('PUT')

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
                                value="{{ old('title', $doc->title) }}"
                                required>
                            @error('title')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                            <div class="alert alert-info mt-2 mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                <small>Thay đổi tiêu đề sẽ tự động cập nhật tên file trên Google Drive</small>
                            </div>
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
                                    <option value="{{ $type->id }}"
                                        {{ (old('category_id', $doc->category_id) == $type->id) ? 'selected' : '' }}>
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
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Danh mục hiện tại: <strong>{{ $doc->category->name ?? 'Chưa phân loại' }}</strong>
                            </small>
                        </div>

                        {{-- Document Type --}}
                        <div class="mb-4">
                            <label for="type" class="form-label fw-semibold">
                                <i class="fas fa-file-alt me-2 text-info"></i>
                                Loại tài liệu <span class="text-danger">*</span>
                            </label>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="type-edit-card {{ $doc->type == 'PDF' ? 'active' : '' }}" onclick="selectEditType('PDF')">
                                        <input type="radio" name="type" value="PDF" id="typePDF" class="d-none"
                                            {{ $doc->type == 'PDF' ? 'checked' : '' }} required>
                                        <label for="typePDF" class="type-label">
                                            <i class="fas fa-file-pdf fa-2x text-danger mb-2"></i>
                                            <div class="fw-bold">PDF</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="type-edit-card {{ $doc->type == 'DOCX' ? 'active' : '' }}" onclick="selectEditType('DOCX')">
                                        <input type="radio" name="type" value="DOCX" id="typeDOCX" class="d-none"
                                            {{ $doc->type == 'DOCX' ? 'checked' : '' }} required>
                                        <label for="typeDOCX" class="type-label">
                                            <i class="fas fa-file-word fa-2x text-primary mb-2"></i>
                                            <div class="fw-bold">DOCX</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="type-edit-card {{ $doc->type == 'SLIDE' ? 'active' : '' }}" onclick="selectEditType('SLIDE')">
                                        <input type="radio" name="type" value="SLIDE" id="typeSLIDE" class="d-none"
                                            {{ $doc->type == 'SLIDE' ? 'checked' : '' }} required>
                                        <label for="typeSLIDE" class="type-label">
                                            <i class="fas fa-file-powerpoint fa-2x text-warning mb-2"></i>
                                            <div class="fw-bold">SLIDE</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="type-edit-card {{ $doc->type == 'OTHER' ? 'active' : '' }}" onclick="selectEditType('OTHER')">
                                        <input type="radio" name="type" value="OTHER" id="typeOTHER" class="d-none"
                                            {{ $doc->type == 'OTHER' ? 'checked' : '' }} required>
                                        <label for="typeOTHER" class="type-label">
                                            <i class="fas fa-file fa-2x text-secondary mb-2"></i>
                                            <div class="fw-bold">KHÁC</div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- File Upload (Optional) --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-cloud-upload-alt me-2 text-warning"></i>
                                Thay thế file (Tùy chọn)
                            </label>

                            <div class="card bg-light border-warning border-2 border-dashed">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <i class="fas fa-exchange-alt fa-3x text-warning mb-3"></i>
                                        <h6 class="fw-bold mb-2">Tải lên file mới để thay thế</h6>
                                        <p class="text-muted small mb-3">File cũ trên Google Drive sẽ bị xóa và thay thế bằng file mới</p>

                                        <div class="file-upload-wrapper">
                                            <input type="file"
                                                class="form-control @error('file') is-invalid @enderror"
                                                id="file"
                                                name="file"
                                                accept=".pdf,.doc,.docx,.ppt,.pptx">
                                            <div class="file-upload-label" id="fileLabel">
                                                <i class="fas fa-folder-open me-2"></i>
                                                Chọn file từ máy tính
                                            </div>
                                        </div>

                                        <small class="text-muted d-block mt-3">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Bỏ trống nếu muốn giữ nguyên file hiện tại
                                        </small>
                                    </div>
                                </div>
                            </div>

                            @error('file')
                            <div class="text-danger mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>



                        {{-- File Preview --}}
                        <div class="file-preview-area d-none mb-4" id="filePreview">
                            <div class="alert alert-success border-success">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="file-icon-preview me-3">
                                            <i class="fas fa-file fa-2x text-success"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                File mới đã chọn
                                            </div>
                                            <div class="fw-bold" id="fileName"></div>
                                            <small class="text-muted" id="fileSize"></small>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile()">
                                        <i class="fas fa-times"></i> Hủy
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- [MỚI] ẢNH BÌA TÀI LIỆU --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-image me-2 text-info"></i>Ảnh bìa tài liệu
                            </label>

                            <div class="d-flex align-items-center gap-4">
                                {{-- Khung hiển thị ảnh hiện tại / Preview ảnh mới --}}
                                <div class="position-relative border rounded-3 overflow-hidden bg-light d-flex align-items-center justify-content-center shadow-sm"
                                    style="width: 120px; height: 160px; min-width: 120px;">

                                    @if($doc->cover_image)
                                    {{-- Trường hợp đã có ảnh bìa --}}
                                    <img id="coverPreview" src="{{ asset('storage/' . $doc->cover_image) }}"
                                        class="w-100 h-100" style="object-fit: cover;" alt="Cover">
                                    @else
                                    {{-- Trường hợp chưa có ảnh --}}
                                    <div id="coverPlaceholder" class="text-center text-muted p-2">
                                        <i class="fas fa-image fa-2x mb-2 opacity-50"></i>
                                        <div style="font-size: 0.75rem; line-height: 1.2;">Chưa có ảnh</div>
                                    </div>
                                    {{-- Ảnh preview ẩn sẵn, hiện ra khi chọn file --}}
                                    <img id="coverPreview" src="" class="w-100 h-100 d-none" style="object-fit: cover;" alt="Preview">
                                    @endif
                                </div>

                                {{-- Input chọn file --}}
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control" name="cover_image" id="coverInput" accept="image/*">
                                    <div class="form-text mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Tải lên ảnh mới để thay thế ảnh cũ. Định dạng: JPG, PNG (Tỉ lệ dọc như bìa sách).
                                    </div>
                                </div>
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

                        <hr class="my-4">

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.documents.index') }}" class="btn btn-lg btn-light border px-4">
                                <i class="fas fa-times me-2"></i>Hủy bỏ
                            </a>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-lg btn-primary px-5" id="updateBtn">
                                    <i class="fas fa-save me-2"></i>Cập nhật
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="card border-danger mt-4">
                <div class="card-header bg-danger bg-opacity-10 border-danger">
                    <h6 class="fw-bold text-danger mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>Vùng nguy hiểm
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-1">Xóa văn bản này</h6>
                            <p class="text-muted mb-0 small">
                                Hành động này sẽ xóa vĩnh viễn văn bản khỏi hệ thống và Google Drive. Không thể hoàn tác!
                            </p>
                        </div>
                        <form action="{{ route('admin.documents.destroy', $doc->id) }}" method="POST" class="ms-3">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('⚠️ CẢNH BÁO:\n\nBạn có chắc chắn muốn xóa văn bản này?\n\n- File sẽ bị xóa khỏi Google Drive\n- Dữ liệu không thể khôi phục\n\nNhấn OK để tiếp tục xóa.')">
                                <i class="fas fa-trash-alt me-2"></i>Xóa vĩnh viễn
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom CSS --}}
<style>
    .edit-header-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.3);
    }

    .file-icon-large {
        width: 80px;
        height: 80px;
        background: #f8f9fc;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .type-edit-card {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        height: 100%;
    }

    .type-edit-card:hover {
        border-color: #4e73df;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .type-edit-card.active {
        border-color: #4e73df;
        background: linear-gradient(135deg, #f0f4ff 0%, #ffffff 100%);
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.2);
    }

    .type-label {
        cursor: pointer;
        margin: 0;
        display: block;
    }

    .file-upload-wrapper {
        position: relative;
        max-width: 400px;
        margin: 0 auto;
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

    .file-upload-wrapper input[type="file"]:hover+.file-upload-label {
        color: #4e73df;
    }

    .file-icon-preview {
        width: 50px;
        height: 50px;
        background: #dcfce7;
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

    code {
        background: #f3f4f6;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    /* Update button loading state */
    #updateBtn.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    #updateBtn.loading::after {
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
</style>

{{-- JavaScript --}}
<script>
    // Type selection
    function selectEditType(type) {
        // Remove active from all
        document.querySelectorAll('.type-edit-card').forEach(card => {
            card.classList.remove('active');
        });

        // Add active to selected
        const selectedCard = document.getElementById('type' + type).closest('.type-edit-card');
        selectedCard.classList.add('active');

        // Check the radio
        document.getElementById('type' + type).checked = true;
    }

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
        fileLabel.innerHTML = '<i class="fas fa-folder-open me-2"></i>Chọn file từ máy tính';
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
    document.getElementById('editForm').addEventListener('submit', function(e) {
        const updateBtn = document.getElementById('updateBtn');
        updateBtn.classList.add('loading');
        updateBtn.disabled = true;
        updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang cập nhật...';
    });

    // --- [MỚI] Xử lý xem trước Ảnh bìa ---
    const coverInput = document.getElementById('coverInput');
    if (coverInput) {
        coverInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('coverPreview');
                    const placeholder = document.getElementById('coverPlaceholder');

                    // Cập nhật src ảnh và hiển thị
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');

                    // Ẩn placeholder (chữ "Chưa có ảnh") nếu đang hiện
                    if (placeholder) {
                        placeholder.classList.add('d-none');
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }
</script>
@endsection