@extends('layouts.admin')

@section('title', 'Quản lý văn bản')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary"><i class="fas fa-folder-open me-2"></i>Quản lý văn bản</h3>
        <a href="{{ route('admin.documents.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle me-2"></i>Thêm văn bản mới
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- THANH CÔNG CỤ TÌM KIẾM & LỌC --}}
    <div class="card mb-3 shadow-sm border-0">
        <div class="card-body p-3 bg-light rounded">
            <form action="{{ route('admin.documents.index') }}" method="GET" class="row g-2 align-items-center">

                {{-- 1. Ô Tìm kiếm từ khóa --}}
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white text-muted border-end-0"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0"
                            placeholder="Nhập tên văn bản..." value="{{ request('search') }}">
                    </div>
                </div>

                {{-- 2. Ô Chọn Danh mục --}}
                <div class="col-md-3">
                    <select name="category_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Tất cả danh mục --</option>
                        @foreach($categories as $group)
                        {{-- Nhóm Cha --}}
                        <optgroup label="{{ $group->name }}">
                            {{-- Nếu muốn chọn cả Nhóm cha thì bỏ comment dòng dưới --}}
                            {{-- <option value="{{ $group->id }}" {{ request('category_id') == $group->id ? 'selected' : '' }}>{{ $group->name }} (Tất cả)</option> --}}

                            @foreach($group->children as $child)
                            <option value="{{ $child->id }}" {{ request('category_id') == $child->id ? 'selected' : '' }}>
                                {{ $child->name }}
                            </option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                </div>

                {{-- 3. Nút Reset --}}
                <div class="col-md-2">
                    @if(request('search') || request('category_id'))
                    <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-undo me-1"></i> Xóa lọc
                    </a>
                    @endif
                </div>

                <div class="col-md-3 text-end">
                    {{-- Hiển thị số lượng kết quả --}}
                    <span class="text-muted fst-italic small">Tìm thấy {{ $docs->total() }} văn bản</span>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        {{-- ĐÃ XÓA: Phần Header chứa các Tab (Pending/Approved...) --}}

        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="30%">Văn bản</th>
                        <th width="20%">Danh mục</th> {{-- CỘT MỚI --}}
                        <th width="15%">Người đăng</th>
                        <th width="15%">Ngày tạo</th>
                        <th width="15%" class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($docs as $doc)
                    <tr>
                        {{-- 1. Cột ID --}}
                        <td>#{{ $doc->id }}</td>

                        {{-- 2. Cột Tên văn bản & Loại file --}}
                        <td>
                            <div class="fw-bold text-dark">{{ $doc->title }}</div>
                            <small class="text-muted"><i class="fas fa-file-alt me-1"></i>{{ strtoupper($doc->type) }}</small>
                        </td>

                        {{-- 3. Cột Danh mục --}}
                        <td>
                            @if($doc->category)
                            {{-- Link bấm vào để lọc theo danh mục này --}}
                            <a href="{{ route('admin.documents.index', ['category_id' => $doc->category_id]) }}"
                                class="badge bg-info text-decoration-none text-dark border">
                                {{ $doc->category->name }}
                            </a>

                            {{-- Hiển thị tên Nhóm Cha (nếu có) --}}
                            @if($doc->category->parent)
                            <div class="small text-muted mt-1" style="font-size: 0.85em;">
                                <i class="fas fa-level-up-alt fa-rotate-90 me-1"></i>
                                Thuộc: {{ $doc->category->parent->name }}
                            </div>
                            @endif
                            @else
                            <span class="text-muted fst-italic small">Chưa phân loại</span>
                            @endif
                        </td>

                        {{-- 4. Cột Người đăng --}}
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                    <i class="fas fa-user text-secondary"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small">{{ $doc->author->fullname ?? 'Unknown' }}</div>
                                    <small class="text-muted" style="font-size: 0.8em;">{{ $doc->author->email ?? '' }}</small>
                                </div>
                            </div>
                        </td>

                        {{-- 5. Cột Ngày tạo --}}
                        <td>{{ $doc->created_at->format('d/m/Y H:i') }}</td>

                        {{-- 6. Cột Hành động --}}
                        <td class="text-end">
                            <div class="btn-group">
                                {{-- Nút Xem --}}
                                @if($doc->drive_path)
                                <a href="https://drive.google.com/file/d/{{ $doc->drive_path }}/view" target="_blank" class="btn btn-sm btn-outline-primary" title="Xem file">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif

                                {{-- Nút Sửa --}}
                                <a href="{{ route('admin.documents.edit', $doc->id) }}" class="btn btn-sm btn-outline-info" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Nút Xóa --}}
                                <form action="{{ route('admin.documents.destroy', $doc->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa vĩnh viễn văn bản này?')" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        {{-- Sửa colspan thành 6 để khớp với số lượng cột tiêu đề --}}
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                            <p>Không tìm thấy văn bản nào.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white">
            {{ $docs->links() }}
        </div>
    </div>
</div>

{{-- MODAL TỪ CHỐI --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Từ chối văn bản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lý do từ chối:</label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Nhập lý do để người đăng chỉnh sửa..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xác nhận Từ chối</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT XỬ LÝ URL CHO MODAL --}}
<script>
    function setRejectId(id) {
        // Cập nhật action của form khi bấm nút mở modal
        let form = document.getElementById('rejectForm');
        form.action = '/admin/documents/' + id + '/reject';
    }
</script>
@endsection