@extends('layouts.admin')

@section('title', 'Quản lý Danh mục')

@section('content')
<div class="container-fluid px-4">
    {{-- Header Section --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold mb-1" style="color: #4e73df;">
                <i class="fas fa-folder-tree me-2"></i>Quản lý Danh mục
            </h2>
            <p class="text-muted mb-0">Tổ chức và phân loại văn bản theo danh mục</p>
        </div>
        <div class="col-md-6 text-md-end">
            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus-circle me-2"></i>Thêm Danh mục
            </button>
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

    {{-- Statistics Cards --}}
    <div class="row g-4 mb-4">
        {{-- Total Categories --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">
                                Tổng danh mục
                            </p>
                            <h3 class="fw-bold mb-0" style="color: #4e73df;">
                                {{ $categories->sum(function($parent) { return 1 + $parent->children->count(); }) }}
                            </h3>
                        </div>
                        <div class="icon-box" style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-folder fa-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Parent Categories --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">
                                Nhóm chính
                            </p>
                            <h3 class="fw-bold mb-0" style="color: #1cc88a;">
                                {{ $categories->count() }}
                            </h3>
                        </div>
                        <div class="icon-box" style="width: 50px; height: 50px; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-folder-open fa-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Internal Categories --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">
                                Danh mục nội bộ
                            </p>
                            <h3 class="fw-bold mb-0" style="color: #f6c23e;">
                                {{ $categories->where('is_internal', 1)->count() + $categories->sum(function($parent) { return $parent->children->where('is_internal', 1)->count(); }) }}
                            </h3>
                        </div>
                        <div class="icon-box" style="width: 50px; height: 50px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-lock fa-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Categories Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 fw-bold" style="color: #4e73df;">
                        <i class="fas fa-list me-2"></i>Cây danh mục
                    </h5>
                    <p class="text-muted mb-0 small">Danh sách tất cả danh mục và nhóm</p>
                </div>
                <div>
                    <button class="btn btn-sm btn-light" onclick="expandAll()">
                        <i class="fas fa-expand-alt me-1"></i>Mở rộng tất cả
                    </button>
                    <button class="btn btn-sm btn-light" onclick="collapseAll()">
                        <i class="fas fa-compress-alt me-1"></i>Thu gọn
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <tr>
                            <th class="text-white fw-semibold" width="45%">Tên Danh mục</th>
                            <th class="text-white fw-semibold" width="20%">Đường dẫn (Slug)</th>
                            <th class="text-white fw-semibold" width="15%">Số văn bản</th>
                            <th class="text-white fw-semibold" width="10%">Trạng thái</th>
                            <th class="text-white fw-semibold text-end" width="10%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $parent)
                        {{-- PARENT ROW --}}
                        <tr class="parent-row" style="background: linear-gradient(to right, #f8f9fc 0%, #ffffff 100%);">
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-sm btn-light me-2 toggle-btn" onclick="toggleChildren({{ $parent->id }})">
                                        <i class="fas fa-chevron-down transition-icon" id="icon-{{ $parent->id }}"></i>
                                    </button>
                                    <div class="category-icon me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-folder text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $parent->name }}</div>
                                        <small class="text-muted">
                                            <i class="fas fa-sitemap me-1"></i>Nhóm chính
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code class="text-muted small">{{ $parent->slug }}</code>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                                    <i class="fas fa-file-alt me-1"></i>{{ $parent->documents->count() }}
                                </span>
                            </td>
                            <td>
                                @if($parent->is_internal)
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-lock me-1"></i>Nội bộ
                                </span>
                                @else
                                <span class="badge bg-success">
                                    <i class="fas fa-globe me-1"></i>Công khai
                                </span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-info"
                                        onclick="openEditModal({{ $parent->id }}, '{{ $parent->name }}', {{ $parent->is_internal }})"
                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                        title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.categories.destroy', $parent->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('⚠️ Xóa nhóm này sẽ xóa tất cả danh mục con bên trong!\n\nBạn có chắc chắn?')"
                                                title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- CHILDREN ROWS --}}
                        @foreach($parent->children as $child)
                        <tr class="child-row child-of-{{ $parent->id }}">
                            <td class="ps-5">
                                <div class="d-flex align-items-center">
                                    <div class="me-2" style="width: 30px;">
                                        <i class="fas fa-level-up-alt fa-rotate-90 text-muted"></i>
                                    </div>
                                    <div class="category-icon me-3" style="width: 35px; height: 35px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-folder text-white" style="font-size: 0.9rem;"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $child->name }}</div>
                                        <small class="text-muted">
                                            <i class="fas fa-arrow-up me-1" style="font-size: 0.7rem;"></i>{{ $parent->name }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code class="text-muted small">{{ $child->slug }}</code>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="fas fa-file-alt me-1"></i>{{ $child->documents->count() }}
                                </span>
                            </td>
                            <td>
                                @if($child->is_internal)
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-lock me-1"></i>Nội bộ
                                </span>
                                @else
                                <span class="badge bg-success">
                                    <i class="fas fa-globe me-1"></i>Công khai
                                </span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-info"
                                        onclick="openEditModal({{ $child->id }}, '{{ $child->name }}', {{ $child->is_internal }})"
                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                        title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.categories.destroy', $child->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('⚠️ Xóa danh mục này?\n\nTất cả văn bản sẽ mất phân loại.')"
                                                title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-folder-open fa-4x text-muted mb-3 opacity-25"></i>
                                    <h5 class="text-muted fw-bold">Chưa có danh mục nào</h5>
                                    <p class="text-muted">Bắt đầu bằng cách tạo danh mục đầu tiên</p>
                                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addModal">
                                        <i class="fas fa-plus me-2"></i>Thêm danh mục đầu tiên
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ADD MODAL --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="modal-title text-white fw-bold">
                        <i class="fas fa-plus-circle me-2"></i>Thêm Danh mục mới
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    {{-- Category Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-tag me-2 text-primary"></i>Tên Danh mục <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" class="form-control" required 
                               placeholder="Ví dụ: Giáo trình, Tài liệu tham khảo...">
                        <small class="text-muted">Tên hiển thị của danh mục</small>
                    </div>

                    {{-- Parent Category --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-sitemap me-2 text-success"></i>Thuộc nhóm
                        </label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- Là Nhóm gốc (Không có cha) --</option>
                            @foreach($categories as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Để trống nếu đây là nhóm chính</small>
                    </div>

                    {{-- Internal Category Checkbox --}}
                    <div class="mb-0">
                        <div class="card border-warning bg-warning bg-opacity-10">
                            <div class="card-body p-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_internal" value="1" id="checkInternal">
                                    <label class="form-check-label fw-bold text-warning" for="checkInternal">
                                        <i class="fas fa-lock me-1"></i>Đây là Danh mục Nội bộ
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Nếu tích chọn: Chỉ <strong>Giảng viên & Admin</strong> mới thấy các tài liệu trong mục này. Sinh viên sẽ không thấy.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Lưu lại
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="editForm" method="POST" action="">
            @csrf @method('PUT')
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <h5 class="modal-title text-white fw-bold">
                        <i class="fas fa-edit me-2"></i>Chỉnh sửa Danh mục
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    {{-- Category Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-tag me-2 text-primary"></i>Tên Danh mục <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>

                    {{-- Internal Category Checkbox --}}
                    <div class="mb-0">
                        <div class="card border-warning bg-warning bg-opacity-10">
                            <div class="card-body p-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_internal" value="1" id="editIsInternal">
                                    <label class="form-check-label fw-bold text-warning" for="editIsInternal">
                                        <i class="fas fa-lock me-1"></i>Đây là Danh mục Nội bộ
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Chỉ Giảng viên & Admin mới thấy các tài liệu trong mục này
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Cập nhật
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Custom CSS --}}
<style>
    .hover-lift {
        transition: all 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    }

    .parent-row {
        border-left: 4px solid #667eea;
    }

    .child-row {
        transition: all 0.3s ease;
    }

    .child-row:hover {
        background-color: #f8f9fc;
    }

    .category-icon {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }

    .parent-row:hover .category-icon,
    .child-row:hover .category-icon {
        transform: scale(1.1);
    }

    .toggle-btn {
        border: none;
        padding: 5px 10px;
        transition: all 0.3s ease;
    }

    .toggle-btn:hover {
        background: #e5e7eb;
    }

    .transition-icon {
        transition: transform 0.3s ease;
    }

    .rotated {
        transform: rotate(-90deg);
    }

    .icon-box {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .empty-state i {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
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

    code {
        background: #f3f4f6;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.85rem;
    }
</style>

{{-- JavaScript --}}
<script>
    // Toggle children visibility
    function toggleChildren(parentId) {
        const children = document.querySelectorAll('.child-of-' + parentId);
        const icon = document.getElementById('icon-' + parentId);
        
        children.forEach(child => {
            if (child.style.display === 'none') {
                child.style.display = 'table-row';
                icon.classList.remove('rotated');
            } else {
                child.style.display = 'none';
                icon.classList.add('rotated');
            }
        });
    }

    // Expand all children
    function expandAll() {
        document.querySelectorAll('.child-row').forEach(row => {
            row.style.display = 'table-row';
        });
        document.querySelectorAll('.transition-icon').forEach(icon => {
            icon.classList.remove('rotated');
        });
    }

    // Collapse all children
    function collapseAll() {
        document.querySelectorAll('.child-row').forEach(row => {
            row.style.display = 'none';
        });
        document.querySelectorAll('.transition-icon').forEach(icon => {
            icon.classList.add('rotated');
        });
    }

    // Open edit modal with data
    function openEditModal(id, name, isInternal) {
        document.getElementById('editForm').action = '/admin/categories/' + id;
        document.getElementById('editName').value = name;
        document.getElementById('editIsInternal').checked = (isInternal == 1);
    }

    // Initialize: Show all children by default
    document.addEventListener('DOMContentLoaded', function() {
        expandAll();
    });
</script>
@endsection