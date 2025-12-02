@extends('layouts.admin')

@section('title', 'Quản lý thành viên')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-users me-2"></i>Danh sách thành viên</h5>
        <span class="badge bg-primary">Tổng: {{ $users->total() }}</span>
    </div>

    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Họ tên / Email</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th>Ngày tham gia</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>#{{ $user->id }}</td>
                    <td>
                        <div class="fw-bold">{{ $user->fullname }}</div>
                        <small class="text-muted">{{ $user->email }}</small>
                    </td>
                    <td>
                        @if($user->role == 'ADMIN')
                        <span class="badge bg-danger">ADMIN</span>
                        @else
                        <span class="badge bg-info text-dark">SV</span>
                        @endif
                    </td>
                    <td>
                        @if($user->is_active)
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>Hoạt động
                        </span>
                        @else
                        <span class="badge bg-secondary">
                            <i class="fas fa-lock me-1"></i>Đã khóa
                        </span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    {{-- Đoạn code hiển thị nút bấm trong admin/users/index.blade.php --}}
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Tùy chọn
                            </button>
                            <ul class="dropdown-menu">
                                {{-- Đổi quyền --}}
                                <li>
                                    <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                        @csrf

                                        {{-- Kiểm tra chính xác role là 'ADMIN' --}}
                                        @if($user->role == 'ADMIN')
                                        {{-- Đang là ADMIN -> Hiện nút hạ xuống SV --}}
                                        <button class="dropdown-item text-danger fw-bold" type="submit"
                                            onclick="return confirm('Giáng cấp Admin này xuống làm Sinh viên?')">
                                            <i class="fas fa-arrow-down me-2"></i>Hạ xuống SV
                                        </button>
                                        @else
                                        {{-- Đang là SV (hoặc khác) -> Hiện nút thăng lên ADMIN --}}
                                        <button class="dropdown-item text-primary fw-bold" type="submit">
                                            <i class="fas fa-arrow-up me-2"></i>Thăng lên ADMIN
                                        </button>
                                        @endif
                                    </form>
                                </li>

                                {{-- ... Các mục Thăng/Giáng cấp và Khóa/Mở khóa ở trên giữ nguyên ... --}}

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                {{-- [MỚI] Mục Chỉnh sửa thông tin --}}
                                <li>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="dropdown-item text-dark">
                                        <i class="fas fa-edit me-2"></i>Chỉnh sửa thông tin
                                    </a>
                                </li>

                                {{-- [MỚI] Mục Xóa thành viên --}}
                                <li>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item text-danger" type="submit"
                                            onclick="return confirm('CẢNH BÁO CỰC MẠNH:\n\nHành động này sẽ xóa vĩnh viễn user khỏi hệ thống.\nBạn có chắc chắn muốn tiếp tục?')">
                                            <i class="fas fa-trash-alt me-2"></i>Xóa vĩnh viễn
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                {{-- Khóa tài khoản (Giữ nguyên) --}}
                                <li>
                                    <form action="{{ route('admin.users.status', $user->id) }}" method="POST">
                                        @csrf

                                        {{-- Nếu đang Hoạt động -> Hiện nút KHÓA --}}
                                        @if($user->is_active)
                                        <button class="dropdown-item text-danger" type="submit"
                                            {{-- Thêm confirm để tránh bấm nhầm --}}
                                            onclick="return confirm('CẢNH BÁO: Bạn có chắc chắn muốn KHÓA tài khoản này? Họ sẽ không thể đăng nhập được nữa.')">
                                            <i class="fas fa-lock me-2"></i>Khóa tài khoản
                                        </button>
                                        @else
                                        {{-- Nếu đang Khóa -> Hiện nút MỞ --}}
                                        <button class="dropdown-item text-success fw-bold" type="submit">
                                            <i class="fas fa-unlock me-2"></i>Mở khóa
                                        </button>
                                        @endif
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $users->links() }}
    </div>
</div>
@endsection