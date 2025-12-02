@extends('layouts.admin')

@section('title', 'Quản lý Danh mục')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- CỘT TRÁI: DANH SÁCH --}}
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-primary"><i class="fas fa-list-ul me-2"></i>Quản lý Danh mục</h3>
                {{-- Nút gọi Modal Thêm mới --}}
                <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus me-2"></i>Thêm Danh mục
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50%">Tên Danh mục</th>
                                <th width="20%">Slug (Đường dẫn)</th>
                                <th width="15%">Số lượng văn bản</th>
                                <th width="15%" class="text-end">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $parent)
                                {{-- HIỂN THỊ CHA --}}
                                <tr class="table-active">
                                    <td class="fw-bold text-primary">
                                        <i class="fas fa-folder me-2"></i>{{ $parent->name }}
                                    </td>
                                    <td class="text-muted small">{{ $parent->slug }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $parent->documents->count() }} văn bản</span>
                                    </td>
                                    <td class="text-end">
                                        {{-- Nút Sửa Cha --}}
                                        <button class="btn btn-sm btn-outline-info" 
                                            onclick="openEditModal({{ $parent->id }}, '{{ $parent->name }}')"
                                            data-bs-toggle="modal" data-bs-target="#editModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        {{-- Nút Xóa Cha --}}
                                        <form action="{{ route('admin.categories.destroy', $parent->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa nhóm này sẽ xóa tất cả danh mục con bên trong. Tiếp tục?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- HIỂN THỊ CON (Loop children) --}}
                                @foreach($parent->children as $child)
                                    <tr>
                                        <td class="ps-5">
                                            <i class="fas fa-level-up-alt fa-rotate-90 me-2 text-muted"></i>
                                            {{ $child->name }}
                                        </td>
                                        <td class="text-muted small">{{ $child->slug }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $child->documents->count() }} văn bản</span>
                                        </td>
                                        <td class="text-end">
                                            {{-- Nút Sửa Con --}}
                                            <button class="btn btn-sm btn-outline-info" 
                                                onclick="openEditModal({{ $child->id }}, '{{ $child->name }}')"
                                                data-bs-toggle="modal" data-bs-target="#editModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            {{-- Nút Xóa Con --}}
                                            <form action="{{ route('admin.categories.destroy', $child->id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa danh mục này?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr><td colspan="4" class="text-center py-4 text-muted">Chưa có danh mục nào.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL THÊM MỚI --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Thêm Danh mục mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{-- Nhập tên --}}
                    <div class="mb-3">
                        <label class="form-label">Tên Danh mục</label>
                        <input type="text" name="name" class="form-control" required placeholder="Ví dụ: Giáo trình...">
                    </div>
                    
                    {{-- Chọn Nhóm Cha --}}
                    <div class="mb-3">
                        <label class="form-label">Thuộc nhóm (Để trống nếu là Nhóm lớn)</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- Là Nhóm gốc (Cha) --</option>
                            @foreach($categories as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL SỬA (Dùng JS để điền ID vào form) --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" method="POST" action="">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Đổi tên Danh mục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên mới</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT XỬ LÝ MODAL SỬA --}}
<script>
    function openEditModal(id, name) {
        // Cập nhật action form: /admin/categories/{id}
        document.getElementById('editForm').action = '/admin/categories/' + id;
        // Điền tên cũ vào ô input
        document.getElementById('editName').value = name;
    }
</script>
@endsection