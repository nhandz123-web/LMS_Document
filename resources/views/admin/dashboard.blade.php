@extends('layouts.admin')

@section('title', 'Tổng quan')

@section('content')
<div class="row mb-4">
  <div class="col-md-4">
    <div class="card text-white bg-primary mb-3">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <h5 class="card-title">Thành viên</h5>
          <h2 class="fw-bold">{{ $stats['users_count'] }}</h2>
        </div>
        <i class="fas fa-users card-icon"></i>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card text-white bg-success mb-3">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <h5 class="card-title">Tổng văn bản</h5>
          <h2 class="fw-bold">{{ $stats['docs_count'] }}</h2>
        </div>
        <i class="fas fa-file-pdf card-icon"></i>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card text-white bg-warning mb-3">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <h5 class="card-title">Đang chờ duyệt</h5>
          <h2 class="fw-bold">{{ $stats['pending_docs'] ?? 0 }}</h2>
        </div>
        <i class="fas fa-clock card-icon"></i>
      </div>
    </div>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-header bg-white py-3">
    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-list me-2"></i>Văn bản mới cập nhật</h5>
  </div>
  <div class="card-body p-0">
    <table class="table table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Tiêu đề văn bản</th>
          <th>Người đăng</th>
          <th>Ngày đăng</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        @forelse($recentDocuments as $doc)
        <tr>
          <td>#{{ $doc->id }}</td>
          <td class="fw-bold">{{ $doc->title ?? 'Không tiêu đề' }}</td>
          <td>{{ $doc->user->fullname ?? 'Ẩn danh' }}</td>
          <td>{{ $doc->created_at->format('d/m/Y H:i') }}</td>
          <td>
            <span class="badge bg-success">Hoạt động</span>
          </td>
          <td>
            <div class="d-flex gap-2">
              {{-- 1. Nút Xem: Mở link Google Drive trong tab mới --}}
              @if($doc->drive_path)
              <a href="https://drive.google.com/file/d/{{ $doc->drive_path }}/view"
                target="_blank"
                class="btn btn-sm btn-outline-primary"
                title="Xem tài liệu">
                <i class="fas fa-eye"></i>
              </a>
              @else
              <button class="btn btn-sm btn-secondary" disabled title="Lỗi file"><i class="fas fa-eye-slash"></i></button>
              @endif

              {{-- 2. Nút Xóa: Bắt buộc dùng Form để bảo mật (CSRF & Method Delete) --}}
              <form action="{{ route('documents.destroy', $doc->id) }}"
                method="POST"
                onsubmit="return confirm('CẢNH BÁO: Bạn có chắc chắn muốn xóa vĩnh viễn văn bản này khỏi hệ thống và Google Drive?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa vĩnh viễn">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-muted">Chưa có văn bản nào trong hệ thống.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer bg-white text-end">
    <a href="{{ url('/documents') }}" class="btn btn-link text-decoration-none">Xem tất cả văn bản &rarr;</a>
  </div>
</div>
@endsection