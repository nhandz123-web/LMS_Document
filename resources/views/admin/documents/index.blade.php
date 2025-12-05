@extends('layouts.admin')

@section('title', 'Quản lý văn bản')

@section('content')
<div class="container-fluid px-4">
    {{-- Header Section --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold mb-1" style="color: #4e73df;">
                <i class="fas fa-file-alt me-2"></i>Quản lý Văn bản
            </h2>
            <p class="text-muted mb-0">Quản lý và theo dõi tất cả văn bản trong hệ thống</p>
        </div>
        <div class="col-md-6 text-md-end">
            {{-- Nút Đồng bộ --}}
            <form action="{{ route('admin.documents.sync') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-warning shadow-sm me-2" onclick="return confirm('Quá trình này có thể mất vài giây. Bạn có chắc muốn quét Google Drive không?')">
                    <i class="fas fa-sync-alt me-2"></i>Đồng bộ Drive
                </button>
            </form>

            {{-- Nút Thêm mới --}}
            <a href="{{ route('admin.documents.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>Thêm văn bản
            </a>
        </div>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
            <div class="flex-grow-1">
                <strong>Thành công!</strong> {{ session('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Search & Filter Card --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.documents.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    {{-- Search Box --}}
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-semibold mb-2">
                            <i class="fas fa-search me-1"></i>Tìm kiếm
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-file-alt text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0"
                                placeholder="Nhập tên văn bản..." value="{{ request('search') }}">
                        </div>
                    </div>

                    {{-- Category Filter --}}
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-semibold mb-2">
                            <i class="fas fa-folder me-1"></i>Danh mục
                        </label>
                        <select name="category_id" class="form-select">
                            <option value="">-- Tất cả danh mục --</option>
                            @foreach($categories as $group)
                            <optgroup label="{{ $group->name }}">
                                @foreach($group->children as $child)
                                <option value="{{ $child->id }}" {{ request('category_id') == $child->id ? 'selected' : '' }}>
                                    {{ $child->name }}
                                </option>
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="col-md-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-search me-2"></i>Tìm kiếm
                            </button>
                            @if(request('search') || request('category_id'))
                            <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-redo"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Results Count --}}
                <div class="mt-3 pt-3 border-top">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Tìm thấy <strong class="text-dark">{{ $docs->total() }}</strong> văn bản
                        </span>
                        @if(request('search') || request('category_id'))
                        <span class="badge bg-primary">
                            <i class="fas fa-filter me-1"></i>Đang lọc kết quả
                        </span>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Documents Table Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <tr>
                            <th class="text-white fw-semibold" width="5%">ID</th>
                            <th class="text-white fw-semibold" width="30%">Văn bản</th>
                            <th class="text-white fw-semibold" width="20%">Danh mục</th>
                            <th class="text-white fw-semibold" width="15%">Người đăng</th>
                            <th class="text-white fw-semibold" width="15%">Ngày tạo</th>
                            <th class="text-white fw-semibold text-end" width="15%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($docs as $doc)
                        <tr class="document-row">
                            {{-- ID Column --}}
                            <td>
                                <span class="badge bg-light text-dark border">#{{ $doc->id }}</span>
                            </td>

                            {{-- Document Title & Type --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="file-icon me-3" style="width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;
                                        @if(strtoupper($doc->type) == 'PDF') background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
                                        @elseif(strtoupper($doc->type) == 'DOCX') background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
                                        @else background: linear-gradient(135deg, #858796 0%, #60616f 100%);
                                        @endif">
                                        @if(strtoupper($doc->type) == 'PDF')
                                            <i class="fas fa-file-pdf text-white"></i>
                                        @elseif(strtoupper($doc->type) == 'DOCX')
                                            <i class="fas fa-file-word text-white"></i>
                                        @else
                                            <i class="fas fa-file text-white"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-1">{{ $doc->title }}</div>
                                        <small class="text-muted">
                                            <i class="fas fa-tag me-1"></i>{{ strtoupper($doc->type) }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            {{-- Category Column --}}
                            <td>
                                @if($doc->category)
                                <a href="{{ route('admin.documents.index', ['category_id' => $doc->category_id]) }}"
                                    class="badge rounded-pill px-3 py-2 text-decoration-none"
                                    style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                                    <i class="fas fa-folder me-1"></i>{{ $doc->category->name }}
                                </a>

                                @if($doc->category->parent)
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-level-up-alt fa-rotate-90 me-1"></i>
                                        {{ $doc->category->parent->name }}
                                    </small>
                                </div>
                                @endif
                                @else
                                <span class="badge bg-light text-muted border">
                                    <i class="fas fa-question-circle me-1"></i>Chưa phân loại
                                </span>
                                @endif
                            </td>

                            {{-- Author Column --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2" style="width: 38px; height: 38px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <span class="text-white fw-bold">{{ strtoupper(substr($doc->author->fullname ?? 'U', 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-semibold small text-dark">{{ $doc->author->fullname ?? 'Unknown' }}</div>
                                        <small class="text-muted" style="font-size: 0.75em;">{{ Str::limit($doc->author->email ?? '', 20) }}</small>
                                    </div>
                                </div>
                            </td>

                            {{-- Created Date Column --}}
                            <td>
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    <div>
                                        <div class="small">{{ $doc->created_at->format('d/m/Y') }}</div>
                                        <div style="font-size: 0.75em;">{{ $doc->created_at->format('H:i') }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Actions Column --}}
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    {{-- View Button --}}
                                    @if($doc->drive_path)
                                    <a href="https://drive.google.com/file/d/{{ $doc->drive_path }}/view" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary"
                                       data-bs-toggle="tooltip" 
                                       title="Xem file">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endif

                                    {{-- Edit Button --}}
                                    <a href="{{ route('admin.documents.edit', $doc->id) }}" 
                                       class="btn btn-sm btn-outline-info"
                                       data-bs-toggle="tooltip" 
                                       title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('admin.documents.destroy', $doc->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('⚠️ Xóa vĩnh viễn văn bản này?\n\nHành động này không thể hoàn tác!')"
                                                data-bs-toggle="tooltip" 
                                                title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-folder-open fa-4x text-muted mb-3 opacity-25"></i>
                                    <h5 class="text-muted fw-bold">Không tìm thấy văn bản nào</h5>
                                    <p class="text-muted">Thử thay đổi bộ lọc hoặc thêm văn bản mới</p>
                                    <a href="{{ route('admin.documents.create') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus me-2"></i>Thêm văn bản đầu tiên
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($docs->hasPages())
        <div class="card-footer bg-white border-top py-3">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="text-muted small">
                        Hiển thị <strong>{{ $docs->firstItem() }}</strong> - <strong>{{ $docs->lastItem() }}</strong> 
                        trong tổng số <strong>{{ $docs->total() }}</strong> văn bản
                    </div>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm justify-content-md-end justify-content-center mb-0">
                            {{-- Previous Button --}}
                            @if ($docs->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $docs->previousPageUrl() }}" rel="prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach ($docs->getUrlRange(1, $docs->lastPage()) as $page => $url)
                                @if ($page == $docs->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Button --}}
                            @if ($docs->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $docs->nextPageUrl() }}" rel="next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <h5 class="modal-title text-white fw-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i>Từ chối văn bản
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-comment-dots me-2 text-danger"></i>Lý do từ chối:
                        </label>
                        <textarea name="reason" 
                                  class="form-control" 
                                  rows="4" 
                                  placeholder="Nhập lý do để người đăng có thể chỉnh sửa..." 
                                  required></textarea>
                        <small class="text-muted mt-2 d-block">
                            <i class="fas fa-info-circle me-1"></i>Người đăng sẽ nhận được thông báo này
                        </small>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-ban me-2"></i>Xác nhận Từ chối
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Custom CSS --}}
<style>
    .document-row {
        transition: all 0.3s ease;
    }

    .document-row:hover {
        background-color: #f8f9fc;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .btn-group .btn {
        transition: all 0.2s ease;
    }

    .btn-group .btn:hover {
        transform: translateY(-2px);
    }

    .file-icon {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }

    .document-row:hover .file-icon {
        transform: scale(1.1);
    }

    .avatar-circle {
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .badge {
        transition: all 0.2s ease;
    }

    .badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .empty-state i {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .card {
        transition: all 0.3s ease;
    }

    .table thead th {
        border: none;
        padding: 15px;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    /* Custom Pagination Styles */
    .pagination {
        gap: 5px;
    }

    .page-link {
        border-radius: 8px !important;
        border: 1px solid #e5e7eb;
        color: #4e73df;
        padding: 8px 12px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background-color: #4e73df;
        color: white;
        border-color: #4e73df;
        transform: translateY(-2px);
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
        color: white;
        box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
    }

    .page-item.disabled .page-link {
        background-color: #f3f4f6;
        border-color: #e5e7eb;
        color: #9ca3af;
    }
</style>

{{-- Scripts --}}
<script>
    function setRejectId(id) {
        let form = document.getElementById('rejectForm');
        form.action = '/admin/documents/' + id + '/reject';
    }

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection