@extends('layouts.admin')

@section('title', 'Quản lý thành viên')

@section('content')
<div class="container-fluid px-4">
    {{-- Header Section --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold mb-1" style="color: #4e73df;">
                <i class="fas fa-users me-2"></i>Quản lý Thành viên
            </h2>
            <p class="text-muted mb-0">Quản lý tài khoản và phân quyền người dùng</p>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="d-inline-block bg-light rounded-3 px-3 py-2 me-2">
                <i class="fas fa-user-check me-2 text-success"></i>
                <span class="fw-semibold">Tổng: {{ $users->total() }} thành viên</span>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-4 mb-4">
        {{-- Active Users --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">
                                Đang hoạt động
                            </p>
                            <h3 class="fw-bold mb-0" style="color: #1cc88a;">
                                {{ $users->where('is_active', true)->count() }}
                            </h3>
                        </div>
                        <div class="icon-box" style="width: 50px; height: 50px; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-check fa-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Admin Users --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">
                                Quản trị viên
                            </p>
                            <h3 class="fw-bold mb-0" style="color: #e74a3b;">
                                {{ $users->where('role', 'ADMIN')->count() }}
                            </h3>
                        </div>
                        <div class="icon-box" style="width: 50px; height: 50px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-shield fa-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Locked Users --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">
                                Tài khoản bị khóa
                            </p>
                            <h3 class="fw-bold mb-0" style="color: #858796;">
                                {{ $users->where('is_active', false)->count() }}
                            </h3>
                        </div>
                        <div class="icon-box" style="width: 50px; height: 50px; background: linear-gradient(135deg, #868f96 0%, #596164 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-lock fa-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Members Table Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 fw-bold" style="color: #4e73df;">
                        <i class="fas fa-list me-2"></i>Danh sách thành viên
                    </h5>
                    <p class="text-muted mb-0 small">Tất cả người dùng trong hệ thống</p>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-2"></i>Lọc
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-users me-2"></i>Tất cả</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-shield me-2"></i>Chỉ Admin</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Chỉ Sinh viên</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-check-circle me-2 text-success"></i>Đang hoạt động</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-lock me-2 text-danger"></i>Đã khóa</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <tr>
                            <th class="text-white fw-semibold" width="5%">ID</th>
                            <th class="text-white fw-semibold" width="30%">Thông tin</th>
                            <th class="text-white fw-semibold" width="15%">Vai trò</th>
                            <th class="text-white fw-semibold" width="15%">Trạng thái</th>
                            <th class="text-white fw-semibold" width="20%">Ngày tham gia</th>
                            <th class="text-white fw-semibold text-end" width="15%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="user-row">
                            {{-- ID Column --}}
                            <td>
                                <span class="badge bg-light text-dark border">#{{ $user->id }}</span>
                            </td>

                            {{-- User Info --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3" style="width: 45px; height: 45px; 
                                        @if($user->role == 'ADMIN')
                                            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
                                        @else
                                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                        @endif
                                        border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                        <span class="text-white fw-bold fs-5">{{ strtoupper(substr($user->fullname, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->fullname }}</div>
                                        <small class="text-muted">
                                            <i class="fas fa-envelope me-1"></i>{{ $user->email }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            {{-- Role Column --}}
                            <td>
                                @if($user->role == 'ADMIN')
                                {{-- 1. ADMIN: Màu Hồng Cam --}}
                                <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; font-weight: 600; box-shadow: 0 2px 5px rgba(250, 112, 154, 0.4);">
                                    <i class="fas fa-crown me-1"></i>QUẢN TRỊ
                                </span>

                                @elseif($user->role == 'GV')
                                {{-- 2. GIẢNG VIÊN: Màu Tím (Sang trọng) --}}
                                <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 600; box-shadow: 0 2px 5px rgba(118, 75, 162, 0.4);">
                                    <i class="fas fa-chalkboard-teacher me-1"></i>GIẢNG VIÊN
                                </span>

                                @else
                                {{-- 3. SINH VIÊN: Màu Xanh Dương --}}
                                <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; font-weight: 600; box-shadow: 0 2px 5px rgba(0, 242, 254, 0.4);">
                                    <i class="fas fa-user-graduate me-1"></i>SINH VIÊN
                                </span>
                                @endif
                            </td>

                            {{-- Status Column --}}
                            <td>
                                @if($user->is_active)
                                <span class="badge bg-success-soft border border-success text-success px-3 py-2 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i>Hoạt động
                                </span>
                                @else
                                <span class="badge bg-danger-soft border border-danger text-danger px-3 py-2 rounded-pill">
                                    <i class="fas fa-lock me-1"></i>Đã khóa
                                </span>
                                @endif
                            </td>

                            {{-- Join Date --}}
                            <td>
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    <div>
                                        <div class="small">{{ $user->created_at->format('d/m/Y') }}</div>
                                        <div style="font-size: 0.75em;">{{ $user->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Actions Dropdown --}}
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle shadow-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-cog me-1"></i>Tùy chọn
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">

                                        {{-- 1. PHẦN PHÂN QUYỀN (Đã cập nhật cho 3 vai trò) --}}
                                        <li class="dropdown-header text-uppercase small fw-bold text-muted">
                                            <i class="fas fa-user-tag me-2"></i>Chọn vai trò
                                        </li>

                                        {{-- Nút set QUẢN TRỊ VIÊN --}}
                                        <li>
                                            <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                                @csrf <input type="hidden" name="role" value="ADMIN">
                                                <button class="dropdown-item d-flex justify-content-between align-items-center {{ $user->role == 'ADMIN' ? 'active' : '' }}" type="submit">
                                                    <span><i class="fas fa-user-shield me-2 text-danger"></i>Quản trị viên</span>
                                                    @if($user->role == 'ADMIN') <i class="fas fa-check"></i> @endif
                                                </button>
                                            </form>
                                        </li>

                                        {{-- Nút set GIẢNG VIÊN --}}
                                        <li>
                                            <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                                @csrf <input type="hidden" name="role" value="GV">
                                                <button class="dropdown-item d-flex justify-content-between align-items-center {{ $user->role == 'GV' ? 'active' : '' }}" type="submit">
                                                    <span><i class="fas fa-chalkboard-teacher me-2 text-primary"></i>Giảng viên</span>
                                                    @if($user->role == 'GV') <i class="fas fa-check"></i> @endif
                                                </button>
                                            </form>
                                        </li>

                                        {{-- Nút set SINH VIÊN --}}
                                        <li>
                                            <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                                @csrf <input type="hidden" name="role" value="SV">
                                                <button class="dropdown-item d-flex justify-content-between align-items-center {{ $user->role == 'SV' ? 'active' : '' }}" type="submit">
                                                    <span><i class="fas fa-user-graduate me-2 text-success"></i>Sinh viên</span>
                                                    @if($user->role == 'SV') <i class="fas fa-check"></i> @endif
                                                </button>
                                            </form>
                                        </li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        {{-- 2. PHẦN CHỈNH SỬA & XÓA --}}
                                        <li class="dropdown-header text-uppercase small fw-bold text-muted">
                                            <i class="fas fa-cog me-2"></i>Thao tác
                                        </li>

                                        {{-- Sửa thông tin --}}
                                        <li>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="dropdown-item">
                                                <i class="fas fa-user-edit me-2 text-info"></i>Chỉnh sửa thông tin
                                            </a>
                                        </li>

                                        {{-- Xóa User --}}
                                        <li>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button class="dropdown-item text-danger" type="submit"
                                                    onclick="return confirm('⚠️ CẢNH BÁO:\n\nHành động này sẽ xóa vĩnh viễn user khỏi hệ thống.\nTất cả dữ liệu liên quan sẽ bị mất.\n\nBạn có chắc chắn?')">
                                                    <i class="fas fa-trash-alt me-2"></i>Xóa vĩnh viễn
                                                </button>
                                            </form>
                                        </li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        {{-- 3. PHẦN BẢO MẬT (KHÓA/MỞ KHÓA) --}}
                                        <li class="dropdown-header text-uppercase small fw-bold text-muted">
                                            <i class="fas fa-shield-alt me-2"></i>Trạng thái
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.users.status', $user->id) }}" method="POST">
                                                @csrf
                                                @if($user->is_active)
                                                <button class="dropdown-item text-warning" type="submit"
                                                    onclick="return confirm('🔒 KHÓA tài khoản này?\n\nNgười dùng sẽ không thể đăng nhập được nữa.')">
                                                    <i class="fas fa-lock me-2"></i>Khóa tài khoản
                                                </button>
                                                @else
                                                <button class="dropdown-item text-success" type="submit">
                                                    <i class="fas fa-unlock me-2"></i>Mở khóa tài khoản
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
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
        <div class="card-footer bg-white border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Hiển thị {{ $users->firstItem() }} - {{ $users->lastItem() }} trong tổng số {{ $users->total() }} thành viên
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        @endif
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

    .user-row {
        transition: all 0.3s ease;
    }

    .user-row:hover {
        background-color: #f8f9fc;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .avatar-circle {
        transition: transform 0.2s ease;
    }

    .user-row:hover .avatar-circle {
        transform: scale(1.1);
    }

    .badge {
        transition: all 0.2s ease;
        font-size: 0.8rem;
    }

    .bg-success-soft {
        background-color: #d4edda !important;
    }

    .bg-danger-soft {
        background-color: #f8d7da !important;
    }

    .dropdown-menu {
        border-radius: 10px;
        padding: 0.5rem 0;
        min-width: 220px;
    }

    .dropdown-item {
        padding: 0.6rem 1.2rem;
        transition: all 0.2s ease;
        border-radius: 5px;
        margin: 0 0.3rem;
    }

    .dropdown-item:hover {
        background-color: #f8f9fc;
        transform: translateX(5px);
    }

    .dropdown-header {
        padding: 0.5rem 1.2rem;
        font-size: 0.7rem;
    }

    .dropdown-divider {
        margin: 0.5rem 0;
    }

    .icon-box {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

    .card {
        transition: all 0.3s ease;
    }

    /* Custom badge hover effects */
    .badge.rounded-pill:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
</style>

{{-- Initialize Bootstrap Dropdowns --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all dropdowns
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
        var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl);
        });
    });
</script>
@endsection