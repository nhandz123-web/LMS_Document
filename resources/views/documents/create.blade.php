@extends('layouts.app')

@section('title', 'Upload tài liệu')

@section('content')
<div class="container" style="max-width: 900px;">
    {{-- Header Section --}}
    <div class="text-center mb-5">
        <div class="upload-icon-wrapper mb-3">
            <i class="fas fa-cloud-upload-alt fa-3x text-primary"></i>
        </div>
        <h2 class="fw-bold mb-2" style="color: #1f2937;">Tải lên tài liệu mới</h2>
        <p class="text-muted mb-0">Chia sẻ kiến thức với cộng đồng</p>
    </div>

    {{-- Error Alert --}}
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-start">
            <div class="me-3">
                <i class="fas fa-exclamation-circle fa-lg"></i>
            </div>
            <div class="flex-grow-1">
                <strong>Có lỗi xảy ra!</strong> Vui lòng kiểm tra lại thông tin:
                <ul class="mb-0 mt-2 ps-3">
                    @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Upload Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf

                {{-- Document Title --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-heading me-2 text-primary"></i>
                        Tiêu đề tài liệu <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           class="form-control form-control-lg" 
                           value="{{ old('title') }}" 
                           placeholder="Ví dụ: Giáo trình Lập trình Web với Laravel"
                           required>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Đặt tên rõ ràng, dễ tìm kiếm
                    </small>
                </div>

                {{-- Document Category --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-folder me-2 text-success"></i>
                        Danh mục <span class="text-danger">*</span>
                    </label>
                    <select name="category_id" class="form-select form-select-lg" required>
                        <option value="">-- Chọn danh mục --</option>
                        <optgroup label="Giáo trình">
                            <option value="1">Lập trình Web</option>
                            <option value="2">Cơ sở dữ liệu</option>
                            <option value="3">Lập trình di động</option>
                        </optgroup>
                        <optgroup label="Đồ án">
                            <option value="4">Đồ án tốt nghiệp</option>
                            <option value="5">Đồ án chuyên ngành</option>
                        </optgroup>
                        <optgroup label="Tài liệu tham khảo">
                            <option value="6">Bài giảng</option>
                            <option value="7">Slide</option>
                        </optgroup>
                    </select>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Chọn danh mục phù hợp để người khác dễ tìm
                    </small>
                </div>

                {{-- Document Type --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-file-alt me-2 text-info"></i>
                        Loại tài liệu <span class="text-danger">*</span>
                    </label>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="type-card" onclick="selectType('PDF')">
                                <input type="radio" name="type" value="PDF" id="typePDF" class="d-none" required>
                                <label for="typePDF" class="type-label">
                                    <i class="fas fa-file-pdf fa-2x text-danger mb-2"></i>
                                    <div class="fw-bold">PDF</div>
                                    <small class="text-muted">Document</small>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="type-card" onclick="selectType('DOCX')">
                                <input type="radio" name="type" value="DOCX" id="typeDOCX" class="d-none" required>
                                <label for="typeDOCX" class="type-label">
                                    <i class="fas fa-file-word fa-2x text-primary mb-2"></i>
                                    <div class="fw-bold">DOCX</div>
                                    <small class="text-muted">Word Document</small>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="type-card" onclick="selectType('SLIDE')">
                                <input type="radio" name="type" value="SLIDE" id="typeSLIDE" class="d-none" required>
                                <label for="typeSLIDE" class="type-label">
                                    <i class="fas fa-file-powerpoint fa-2x text-warning mb-2"></i>
                                    <div class="fw-bold">Slide</div>
                                    <small class="text-muted">Presentation</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- File Upload --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-upload me-2 text-warning"></i>
                        Chọn file <span class="text-danger">*</span>
                    </label>
                    <div class="upload-area" id="uploadArea">
                        <input type="file" 
                               name="file" 
                               id="fileInput" 
                               class="d-none" 
                               accept=".pdf,.doc,.docx,.ppt,.pptx"
                               required>
                        <div class="upload-content text-center py-5">
                            <i class="fas fa-cloud-upload-alt fa-4x text-muted mb-3"></i>
                            <h5 class="fw-bold text-dark mb-2">Kéo thả file vào đây</h5>
                            <p class="text-muted mb-3">hoặc</p>
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
                                <i class="fas fa-folder-open me-2"></i>Chọn file từ máy tính
                            </button>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Hỗ trợ: PDF, DOCX, PPTX (Tối đa 50MB)
                                </small>
                            </div>
                        </div>
                        <div class="file-preview d-none" id="filePreview">
                            <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file fa-2x text-primary me-3"></i>
                                    <div>
                                        <div class="fw-bold" id="fileName"></div>
                                        <small class="text-muted" id="fileSize"></small>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeFile()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description (Optional) --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-align-left me-2 text-secondary"></i>
                        Mô tả (Tùy chọn)
                    </label>
                    <textarea name="description" 
                              class="form-control" 
                              rows="4" 
                              placeholder="Thêm mô tả ngắn về nội dung tài liệu...">{{ old('description') }}</textarea>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Mô tả chi tiết giúp người khác hiểu rõ hơn về tài liệu
                    </small>
                </div>

                {{-- Terms Checkbox --}}
                <div class="mb-4">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                                <label class="form-check-label" for="agreeTerms">
                                    Tôi xác nhận rằng tài liệu này không vi phạm bản quyền và tuân thủ 
                                    <a href="#" class="text-primary">điều khoản sử dụng</a> của hệ thống.
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex gap-3 justify-content-end">
                    <a href="{{ route('home') }}" class="btn btn-lg btn-light px-4">
                        <i class="fas fa-times me-2"></i>Hủy bỏ
                    </a>
                    <button type="submit" class="btn btn-lg btn-primary px-5" id="submitBtn">
                        <i class="fas fa-cloud-upload-alt me-2"></i>Tải lên
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tips Section --}}
    <div class="card border-0 bg-light mt-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3">
                <i class="fas fa-lightbulb text-warning me-2"></i>
                Mẹo để tài liệu của bạn được nhiều người xem:
            </h6>
            <ul class="mb-0 ps-3">
                <li class="mb-2">Đặt tên tiêu đề rõ ràng, súc tích</li>
                <li class="mb-2">Chọn đúng danh mục và loại tài liệu</li>
                <li class="mb-2">Viết mô tả chi tiết về nội dung</li>
                <li class="mb-0">Đảm bảo file có chất lượng tốt và đầy đủ nội dung</li>
            </ul>
        </div>
    </div>
</div>

{{-- Custom CSS --}}
<style>
    .upload-icon-wrapper {
        animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .type-card {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        height: 100%;
    }

    .type-card:hover {
        border-color: #4e73df;
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .type-card input:checked + .type-label {
        color: #4e73df;
    }

    .type-card:has(input:checked) {
        border-color: #4e73df;
        background: linear-gradient(135deg, #f0f4ff 0%, #ffffff 100%);
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.2);
    }

    .type-label {
        cursor: pointer;
        margin: 0;
        display: block;
    }

    .upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        padding: 10px;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .upload-area:hover {
        border-color: #4e73df;
        background: #f0f4ff;
    }

    .upload-area.dragover {
        border-color: #4e73df;
        background: #e0e7ff;
        transform: scale(1.02);
    }

    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .card {
        transition: all 0.3s ease;
    }

    /* Loading state */
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
        to { transform: rotate(360deg); }
    }
</style>

{{-- JavaScript --}}
<script>
    // Type selection
    function selectType(type) {
        document.getElementById('type' + type).checked = true;
    }

    // File input handling
    const fileInput = document.getElementById('fileInput');
    const uploadArea = document.getElementById('uploadArea');
    const filePreview = document.getElementById('filePreview');
    const uploadContent = uploadArea.querySelector('.upload-content');

    fileInput.addEventListener('change', handleFileSelect);

    function handleFileSelect(e) {
        const file = e.target.files[0];
        if (file) {
            displayFile(file);
        }
    }

    function displayFile(file) {
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        
        uploadContent.classList.add('d-none');
        filePreview.classList.remove('d-none');
    }

    function removeFile() {
        fileInput.value = '';
        uploadContent.classList.remove('d-none');
        filePreview.classList.add('d-none');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    // Drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            displayFile(files[0]);
        }
    });

    // Form submission
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
    });
</script>
@endsection