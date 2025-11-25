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
                        @if($user->role === 'admin')
                            <span class="badge bg-danger">Quản trị viên</span>
                        @else
                            <span class="badge bg-secondary">Thành viên</span>
                        @endif
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-dark">Đã khóa</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Tùy chọn
                            </button>
                            <ul class="dropdown-menu">
                                {{-- Đổi quyền --}}
                                <li>
                                    <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit">
                                            <i class="fas fa-user-shield me-2"></i>
                                            {{ $user->role === 'admin' ? 'Hạ xuống User' : 'Thăng lên Admin' }}
                                        </button>
                                    </form>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                {{-- Khóa tài khoản --}}
                                <li>
                                    <form action="{{ route('admin.users.status', $user->id) }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item {{ $user->is_active ? 'text-danger' : 'text-success' }}" type="submit">
                                            <i class="fas {{ $user->is_active ? 'fa-lock' : 'fa-unlock' }} me-2"></i>
                                            {{ $user->is_active ? 'Khóa tài khoản' : 'Mở khóa' }}
                                        </button>
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