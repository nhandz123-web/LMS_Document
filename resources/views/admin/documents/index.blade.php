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

    <div class="card shadow-sm">
        {{-- ĐÃ XÓA: Phần Header chứa các Tab (Pending/Approved...) --}}

        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="40%">Văn bản</th> {{-- Tăng độ rộng --}}
                        <th width="20%">Người đăng</th>
                        {{-- ĐÃ XÓA: Cột Trạng thái --}}
                        <th width="15%">Ngày tạo</th>
                        <th width="10%" class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($docs as $doc)
                    <tr>
                        <td>#{{ $doc->id }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $doc->title }}</div>
                            <small class="text-muted"><i class="fas fa-file-alt me-1"></i>{{ strtoupper($doc->type) }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                    <i class="fas fa-user text-secondary"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small">{{ $doc->author->fullname ?? 'Unknown' }}</div>
                                    <small class="text-muted">{{ $doc->author->email ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        {{-- ĐÃ XÓA: Cột hiển thị Badge Pending/Approved --}}

                        <td>{{ $doc->created_at->format('d/m/Y H:i') }}</td>

                        <td class="text-end">
                            <div class="btn-group">
                                {{-- Nút Xem --}}
                                @if($doc->drive_path)
                                <a href="https://drive.google.com/file/d/{{ $doc->drive_path }}/view" target="_blank" class="btn btn-sm btn-outline-primary" title="Xem file">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif

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
                        <td colspan="5" class="text-center py-5 text-muted"> {{-- Sửa colspan thành 5 --}}
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